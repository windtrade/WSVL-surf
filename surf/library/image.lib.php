<?php
/*
* image.lib.php
*
* class to access Image table
*
* 09-03-2014 : Huug	: Creation
*/

require_once "general.lib.php";
require_once "table.lib.php";

class image extends table
{

const largeWidth = 600;
const smallWidth = 300;
const thumbWidth = 75;
    private $tbDefine = "SQL_TBIMAGE";

    protected $structure = array(
        "id" => array(
            "label" => "Evenementnr.",
            "default" => "Nieuw",
            "role" => "public",
            "mandatory" => "0",
            "type" => "number",
            "protected" => "1",
            "check" => ""),
        "userId" => array(
            "label" => "Gebruikersnr.",
            "default" => "Nieuw",
            "role" => "public",
            "mandatory" => "0",
            "type" => "number",
            "protected" => "1",
            "check" => ""),
        "timestamp" => array(
            "label" => "Laatste wijziging",
            "default" => "",
            "role" => "public",
            "mandatory" => "0",
            "type" => "datetime_local",
            "protected" => "1",
            "check" => ""),
        "eventId" => array(
            "label" => "Evenementnr.",
            "default" => "Nieuw",
            "role" => "public",
            "mandatory" => "0",
            "type" => "number",
            "protected" => "1",
            "check" => ""),
        "category" => array(),
        "img" => array(
            "label" => "Afbeelding",
            "default" => "",
            "role" => "public",
            "mandatory" => "1",
            "type" => "image",
            "protected" => "0",
            "check" => ""),
        "title" => array(
            "label" => "Titel",
            "default" => "",
            "role" => "public",
            "type" => "text",
            "protected" => "0",
            "check" => ""),
        "description" => array(
            "label" => "Beschrijving.",
            "default" => "",
            "role" => "public",
            "mandatory" => "0",
            "type" => "textarea",
            "protected" => "0",
            "check" => ""));

    protected $supported_types = array(
        "image/jpeg",
        "image/png",
        "image/gif");


    public function __construct()
    {
        if (defined($this->tbDefine)) {
            parent::__construct(SQL_TBIMAGE);
        } else {
            genSetError($this->tbDefine . " not defined");
        }
        $this->structure["category"] = general::getCategoryDefinition();
    }
    
    public function get($id)
    {
        return parent::get(array(array("col" => "id", "oper" => "=", "val" => $id)));
    }

    private function getFileAttr($filename, $attr)
    {
        if (!array_key_exists($filename, $_FILES)) {
            genSetError("File niet in upload: $filename");
            return false;
        }
        $this_FILE = $_FILES[$filename];
        if (strlen($this_FILE["name"]) == 0)
            return false;
        if (false === array_search($this_FILE["type"], $this->supported_types)) {
            genSetError("File " . $this_FILE["name"] . " heeft onbekend bestandstype: " . $this_FILE["type"]);
            return false;
        }
        return $this_FILE[$attr];
    }

    /*
    * return an image identifier in a way that fits the file type
    * returns FALSE on an unsupported type,
    * or when the file does not exist
    */
    private function imageFromAnything($filename, $fileType)
    {
        if (!(imagetypes() & $fileType)) {
            genSetError("Image type $fileType not supported by PHP:" . imagetypes());
            return false;
        }
        switch ($fileType) {
            case IMG_GIF:
                return imagecreatefromgif($filename);
                break;
            case IMG_JPG:
                return imagecreatefromjpeg($filename);
                break;
            case IMG_PNG:
                return imagecreatefrompng($filename);
                break;
            case IMG_WBMP:
                return imagecreatefromwbmp($filename);
                break;
        }
        genSetError("Bestandstype wordt niet ondersteund");
    }
    private function imageAnything($image, $filename, $fileType)
    {
        if (!(imagetypes() & $fileType)) {
            genSetError("Image type not supported by PHP");
            return false;
        }
        switch ($fileType) {
            case IMG_GIF:
                return imagegif($image, $filename);
                break;
            case IMG_JPG:
                return imagejpeg($image, $filename);
                break;
            case IMG_PNG:
                return imagepng($image, $filename);
                break;
            case IMG_WBMP:
                return imagewbmp($image, $filename);
                break;
        }
        genSetError("Bestandstype wordt niet ondersteund");
    }

    public static function fileFromId($id)
    {
        if ($id < 0)
            return false;
        return sprintf("%06d", $id);
    }

    private static function urlFromFile($fileName)
    {
        $cnt = sscanf($fileName, "%d", $id);
        $result = IMAGE_ROOT_URL . image::relativeDirFromId($id) . $fileName;
        return $result;

    }

    private static function getOldUrl($id, $size)
    {
        $imgDir = IMAGE_FILE_ROOT . "/news/";
        $imgUrlDir = IMAGE_ROOT_URL . "/news/";
        if (file_exists($imgDir) && is_dir($imgDir)) {
            $dir = dir($imgDir);
            $origFile = false;
            $wamtedFile = false;
            while (false !== ($entry = $dir->read())) {
                if (preg_match("/^0*$id\.[^.]*$/", $entry)) {
                    $origFile = $entry;
                } else
                    if (preg_match("/^0*$id" . "_?" . $size . "\.[^.]*$/i", $entry)) {
                        return $imgUrlDir . $entry;
                    }
            }
            if ($origFile !== false) {
                $wantedFile = preg_replace('/^(.*)(\.[^.*])/', '$1_' . $size . '$2', $origFile);
                list($width, $height, $imgType) = getImageSize($imgDir . $origFile);
                $newWidth = image::largeWidth;
                switch (strtolower($size)) {
                    case 'small':
                        $newWidth = image::smallWidth;
                        break;
                    case 'thumb':
                        $newWidth = image::thumbWidth;
                        break;
                }
                if ($width <= $newWidth) {
                    return $imgUrlDir . $origFile;
                }
                $wantedHeight = round($height * $newWidth / $width);
                $imOrig = image::imageFromAnything($imgDir . $origFile, $imgType);
                if ($imOrig === false)
                    return false;
                $imWanted = imagecreatetruecolor($newWidth, $wantedHeight);
                imagecopyresampled($imWanted, $imOrig, 0, 0, 0, 0, $newWidth, $wantedHeight, $width,
                    $height);
                $result = image::imageAnything($imWanted, $imgDir . $wantedFile, $imgType);
                if ($result === false) {
                    return $result;
                } else {
                    return $imgUrlDir . $wantedFile;
                }
            }
        }
    }
    public static function getUrl($id, $size)
    {
        $imgDir = image::dirFromId($id);
        $imgFileBase = image::fileFromId($id);
        if (strlen($size) > 0)
            $imgFileBase .= "_$size";
        if (file_exists($imgDir) && is_dir($imgDir)) {
            $dir = dir($imgDir);
            while (false !== ($entry = $dir->read())) {
                if (preg_match("/^$imgFileBase\.[^.]*$/", $entry)) {
                    return image::urlFromFile($entry);
                }
            }
        }
        $url = image::getOldUrl($id, $size);
        if ($url !== false)
            return $url;
        return image::imageNotFound($size);
    }

    public function imageNotFound($size)
    {
        $notFound = "imgNotFound" . (strlen($size) > 0 ? "_$size" : "") . "png";
        return IMAGE_ROOT_URL . $notFound;
    }

    private static function dirFromId($id)
    {
        return IMAGE_FILE_ROOT . image::relativeDirFromId($id);
    }
    private static function relativeDirFromId($id)
    {
        $dirname = preg_replace("/(\d\d)/", 'img$1/', image::fileFromId($id));
        return $dirname;
    }

    /*
    * insert the image description in the table,
    * save the uploaded file, make small and a thumbnail copy
    * the name of the field name of the uploaded image is part of $new
    */
    public function insert($new)
    {
        $tmp = $this->getFileAttr($new["fileField"], 'tmp_name');
        unset($new["fileField"]);
        if ($tmp === false)
            return false;
        if (strlen($tmp) == 0)
            return false;
        $dt = new DateTime();
        $new["timestamp"] = $dt->format("Y-m-d H:i:s");
        parent::insert($new);
        $new["id"] = $this->getLastId();
        $dest = $this->fileFromId($new["id"]);

        $dirname = $this->dirFromId($new["id"]);
        if (file_exists($dirname)) {
            if (!is_dir($dirname)) {
                $error = "No directory for image $dest";
                genSetError($error);
                genLogVar("Error", $error);
                return;
            }
        } else {
            $old_umask = umask(0);
            if (!mkdir($dirname, 0777, true)) {
                $error = "Cannot create directory for image $dirname";
                genSetError($error);
                genLogVar("Error", $error);
                umask($old_umask);
                return false;
            }
            umask($old_umask);
            if (file_exists($dirname)) {
            } else {
            }
        }
        list($width, $height, $imgType) = getImageSize($tmp);
        $imOrig = $this->imageFromAnything($tmp, $imgType);
        $ext = image_type_to_extension($imgType);
        if ($imOrig === false)
            return false;
        $largeHeight = round($height * image::largeWidth / $width);
        $smallHeight = round($height * image::smallWidth / $width);
        $thumbHeight = round($height * image::thumbWidth / $width);
        $imLarge = imagecreatetruecolor(image::largeWidth, $largeHeight);
        $imSmall = imagecreatetruecolor(image::smallWidth, $smallHeight);
        $imThumb = imagecreatetruecolor(image::thumbWidth, $thumbHeight);
        imagecopyresized($imLarge, $imOrig, 0, 0, 0, 0, image::largeWidth, $largeHeight, $width,
            $height);
        imagecopyresized($imSmall, $imOrig, 0, 0, 0, 0, image::smallWidth, $smallHeight, $width,
            $height);
        imagecopyresized($imThumb, $imOrig, 0, 0, 0, 0, image::thumbWidth, $thumbHeight, $width,
            $height);
        $result = $this->imageAnything($imOrig, $dirname . $dest . $ext, $imgType);
        if ($result === false)
            return false;
        $result = $this->imageAnything($imLarge, $dirname . $dest . "_large" . $ext, $imgType);
        if ($result === false)
            return false;
        $result = $this->imageAnything($imSmall, $dirname . $dest . "_small" . $ext, $imgType);
        if ($result === false)
            return false;
        $result = $this->imageAnything($imThumb, $dirname . $dest . "_thumb" . $ext, $imgType);
        return $result;
    }
}
?>
