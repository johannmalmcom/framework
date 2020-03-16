<?php

use UI\Tag;

// Box
function centerBox($title, $subtitle, $links) {
    return Tag::divider(
        Tag::title($title, 1).
        Tag::paragraph($subtitle).
        Tag::divider(
            Tag::anchor($links[0][0], $links[0][1]). " &bull; " .
            Tag::anchor($links[1][0], $links[1][1]). " &bull; " .
            Tag::anchor($links[2][0], $links[2][1])
        , [
            "links"
        ])
    , [
        "centerBox"
    ]);
}

// View
function view($title, $body, $meta) {
    $bodyHtml = "";
    foreach($body as $part) {
        $bodyHtml .= $part;
    }
    
    return Tag::general("html", [],
                Tag::general("head", [],
                    Tag::general("meta", [
                        "charset" => "utf-8"
                    ]).
                    Tag::general("title", [], $title).
                    Tag::general("meta", [
                        "name" => "author",
                        "content" => $meta["author"] ?? ""
                    ]).
                    Tag::general("meta", [
                        "name" => "description",
                        "content" => $meta["description"] ?? ""
                    ]).
                    Tag::general("meta", [
                        "name" => "keywords",
                        "content" => implode(", ", $meta["keywords"]) ?? ""
                    ]).
                    Tag::general("link", [
                        "type" => "text/css",
                        "rel" => "stylesheet",
                        "href" => "/css/global.css"
                    ])
                ).
                Tag::general("body", [], 
                    $bodyHtml.
                    Tag::general("script", [
                        "type" => "text/javascript",
                        "src" => "/js/app.js"
                    ])
                )
           );
}

?>