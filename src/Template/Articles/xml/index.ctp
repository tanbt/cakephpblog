<?php

/**
 * If we wanted to modify the data before it is converted into XML
 * we should not define the _serialize view variable, and instead use template files.
 * We place the REST views for our RecipesController inside src/Template/recipes/xml.
 * We can also use the Xml for quick-and-easy XML output in those views.
 * Here’s what our index view might look like:
 */

/**
 * Manually convert
 */

$content = '<?xml version="1.0" encoding="utf-8"?>';
$content .= '<articles>';
foreach ($articles as $article) {
    $content .= "<article>";
    $content .= "<id>{$article->id}</id>";
    $content .= "<title>{$article->title}</title>";
    $content .= "<body>{$article->body}</body>";
    $content .= "</article>";
}
$content .= '</articles>';
$xml = \Cake\Utility\Xml::build($content);
echo $xml->asXML();


/**
 * Using array builder
 */
/*
$data = array();
$data['articles'] = array();

foreach ($articles as $article) {
    array_push($data['articles'], array(
        'article' => array(
            'id'        =>  $article->id,
            'title'     =>  $article->title,
            'body'      =>  $article->body,
        )
    ));
}
var_dump($data);exit;
$xml = \Cake\Utility\Xml::fromArray($data);
echo $xml->asXML();
*/