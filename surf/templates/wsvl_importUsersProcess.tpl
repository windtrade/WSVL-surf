<?xml version="1.0" ?>
<response>
{block name="body"}
<errors>
{foreach $errors as $error}
<div name="error">{$error}</div>
{/foreach}
</errors>
<results>
{for $i = 0; $i < count($status); $i++}
<result>
<group>{$group[$i]}</group>
<status>{$status[$i]}</status>
<uniqueKey>{$uniqueKey[$i]}</uniqueKey>
<error>{$recordError[$i]}</error>
</result>
{/for}
</results>
</response>
{/block}
