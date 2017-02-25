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
        return parent::getOne(array("id" => $id));
    }

    /** return outer dimensions of any image (large/small/thumb) */
    public static function dimensions()
    {
        return array(
            "large" => array("w" => 600, "h" => 450),
            "small" => array("w" => 300, "h" => 225),
            "thumb" => array("w" => 75, "h" => 56));
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
        return false;
    }
    private function imageAnything($image, $filename, $fileType)
    {
        if (!(imagetypes() & $fileType)) {
            genSetError("Image type not supported by PHP");
            return false;
        }
        $result = false;
        switch ($fileType) {
            case IMG_GIF:
                $result =  imagegif($image, $filename);
                break;
            case IMG_JPG:
                $result =  imagejpeg($image, $filename);
                break;
            case IMG_PNG:
                $result =  imagepng($image, $filename);
                break;
            case IMG_WBMP:
                $result =  imagewbmp($image, $filename);
                break;
            default:
                genSetError("Bestandstype wordt niet ondersteund");
                break;
        }
        return $result;
    }

    public static function fileFromId($id)
    {
        if ($id < 0)
            return false;
        return sprintf("%06d", $id);
    }

    public static function urlFromFile($fileName)
    {
        sscanf($fileName, "%d", $id);
        $result = IMAGE_ROOT_URL . image::relativeDirFromId($id) . $fileName;
        return $result;

    }

    /**
     * @param $old image file
     * @param (out) $original['w']  $original['h'] $original['imgType']
     * @return array by size (large/small/thumb) new width and height
     */
    public static function getNewSizes($old, &$o)
    {
        list($o["w"], $o["h"], $o["imgType"]) = getImageSize($old);
        $dim = image::dimensions();
        $nS = $dim;
        $long = "w";
        $short = "h";
        if ($o["w"] < $o["h"]) {
            $short = "w";
            $long = "h";
        }
        foreach (array_keys($dim) as $key) {
            if ($dim[$key][$long] < $o[$long]) {
                $nS[$key][$long] = $dim[$key][$long];
                $nS[$key][$short] = ceil($dim[$key][$long] * $o[$short] / $o[$long]);
            }
        }
        return $nS;
    }

    public static function getOldUrl($id, $size)
    {
        if (!is_numeric($id)) {
            if (preg_match('/^http/', $id)) return $id;
            genLogVar(__FUNCTION__." id", $id);
            return "";
        }
        $imgDir = IMAGE_FILE_ROOT . "/news/";
        $imgUrlDir = IMAGE_ROOT_URL . "/news/";
        if (file_exists($imgDir) && is_dir($imgDir)) {
            $dir = dir($imgDir);
            $origFile = false;
            $origRegex = '/^0*"'.$id.'\\.[^.]*$/';
            $imgRegex = '/^0*'.$id . "_?" . $size . '\\.[^.]*$/i';
            try {
                while (false !== ($entry = $dir->read())) {
                    if (preg_match($origRegex, $entry)) {
                        $origFile = $entry;
                    } else
                        if (preg_match($imgRegex, $entry)) {
                            return $imgUrlDir . $entry;
                        }
                }
            } catch (Exception $e){
                genLogVar(__FUNCTION__."error", $e.message);
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
        return false;
    }

    /**
     * @param $id: id of requested image
     * @param $size: valid size (large/small/thumb)
     * @return bool|string false or url for requested image of for file not found
     */
    public static function getUrl($id, $size)
    {
        $imgDir = image::dirFromId($id);
        $imgFileBase = image::fileFromId($id);
        if (isset($size) && strlen($size) > 0)
            $imgFileBase .= "_$size";
        if (file_exists($imgDir) && is_dir($imgDir)) {
            $dir = dir($imgDir);
            while (false !== ($entry = $dir->read())) {
                if (preg_match('/^'.$imgFileBase.'\.[^.]*$/', $entry)) {
                    return image::urlFromFile($entry);
                }
            }
        }
        $url = image::getOldUrl($id, $size);
        if ($url !== false)
            return $url;
        return image::imageNotFound($size);
    }

    public static function imageNotFound($size)
    {
        $notFound = "imgNotFound" . (strlen($size) > 0 ? "_$size" : "") . ".png";
        return IMAGE_ROOT_URL . $notFound;
    }

    public static function dirFromId($id)
    {
        return IMAGE_FILE_ROOT . image::relativeDirFromId($id);
    }
    public static function relativeDirFromId($id)
    {
        $dirname = preg_replace('/(\d\d)/', 'img$1/', image::fileFromId($id));
        return $dirname;
    }

    /**
     * insert the image description in the table,
     * save the uploaded file, make small and a thumbnail copy
     * the name of the field name of the uploaded image is part of $new
     *
     * @param $arr
     * @return bool
     */
    public function insert($arr)
    {
        $result = true;
        $ext="";
        $tmp = $this->getFileAttr($arr["fileField"], 'tmp_name');
        unset($arr["fileField"]);
        if ($tmp === false || strlen($tmp) == 0) return false;
        $sizes = $this->getNewSizes($tmp, $orig);
        $dt = new DateTime();
        $arr["timestamp"] = $dt->format("Y-m-d H:i:s");
        parent::insert($arr);
        $arr["id"] = $this->getLastId();
        $dest = $this->fileFromId($arr["id"]);

        $dirname = $this->dirFromId($arr["id"]);
        if (file_exists($dirname)) {
            if (!is_dir($dirname)) {
                $error = "No directory for image $dest";
                genSetError($error);
                genLogVar("Error", $error);
                $result = false;
            }
        } else {
            $old_umask = umask(0);
            if (!mkdir($dirname, 0777, true)) {
                $error = "Cannot create directory for image $dirname";
                genSetError($error);
                genLogVar("Error", $error);
                $result = false;
            }
            umask($old_umask);
        }
        if ($result) {
            $imOrig = $this->imageFromAnything($tmp, $orig["imgType"]);
            $ext = image_type_to_extension($orig["imgType"]);
            $result = ($imOrig != false);
        }
        if ($result) {
            foreach ($sizes as $size => $dim) {
                $newImg = imagecreatetruecolor($dim["w"], $dim["h"]);
                if (isset($imOrig)) {
                    $result = imagecopyresampled($newImg, $imOrig, 0, 0, 0, 0, $dim["w"], $dim["h"], $orig["w"], $orig["h"]);

                    if ($result) {
                        $result = $this->imageAnything($newImg, $dirname . $dest . "_" . $size . $ext, $orig["imgType"]);
                    }
                }
            }
        }
        return ($result? $arr: $result);
    }
}

