<?php

namespace UI;

class Tag {
    
    public static function title($text, $size, $classes=[]) {
        return Render::htmlTag("h".$size, [
            "class" => array_merge([
                "title"
            ], $classes)
        ], $text);
    }
    
    public static function paragraph($text, $classes=[]) {
        return Render::htmlTag("p", [
            "class" => array_merge([
                "paragraph"
            ], $classes)
        ], $text);
    }
    
    public static function anchor($text, $hyperreference, $classes=[]) {
        return Render::htmlTag("a", [
            "class" => array_merge([
                "anchor"
            ], $classes),
            "href" => $hyperreference
        ], $text);
    }
    
    public static function image($alt, $source, $classes=[]) {
        return Render::htmlTag("img", [
            "class" => array_merge([
                "image"
            ], $classes),
            "src" => $source,
            "alt" => $alt
        ]);
    }
    
    public static function divider($content, $classes=[]) {
        return Render::htmlTag("div", [
            "class" => array_merge([
                "layer"
            ], $classes)
        ], $content);
    }
    
    public static function form($content, $action, $classes=[]) {
        return Render::htmlTag("form", [
            "class" => array_merge([
                "form"
            ], $classes),
            "action" => $action,
            "method" => "post",
            "enctype" => "multipart/form-data"
        ], $content);
    }
    
    public static function inputText($name, $placeholder, $value, $classes=[]) {
        return Render::htmlTag("input", [
            "class" => array_merge([
                "input"
            ], $classes),
            "type" => "text",
            "name" => $name,
            "id" => $name,
            "placeholder" => $placeholder,
            "value" => $value
        ]);
    }
    
    public static function inputPassword($name, $placeholder, $value, $classes=[]) {
        return Render::htmlTag("input", [
            "class" => array_merge([
                "input"
            ], $classes),
            "type" => "password",
            "name" => $name,
            "id" => $name,
            "placeholder" => $placeholder,
            "value" => $value
        ]);
    }
    
    public static function inputFile($name, $placeholder, $value, $classes=[]) {
        return Render::htmlTag("input", [
            "class" => array_merge([
                "input"
            ], $classes),
            "type" => "file",
            "name" => $name,
            "id" => $name,
            "placeholder" => $placeholder,
            "value" => $value
        ]);
    }
    
    public static function inputTextarea($name, $placeholder, $value, $classes=[]) {
        return Render::htmlTag("textarea", [
            "class" => array_merge([
                "input"
            ], $classes),
            "name" => $name,
            "id" => $name,
            "placeholder" => $placeholder
        ], $value);
    }
    
    public static function buttonSubmit($value, $classes=[]) {
        return Render::htmlTag("button", [
            "class" => array_merge([
                "input"
            ], $classes),
            "type" => "submit"
        ], $value);
    }
    
    public static function button($text, $hyperreference, $classes=[]) {
        return Render::htmlTag("a", [
            "class" => array_merge([
                "button"
            ], $classes),
            "href" => $hyperreference
        ], $text);
    }
    
    public static function general($tag, $attributes, $contents="") {
        return Render::htmlTag($tag, $attributes, $contents);
    }
}

class Render {
    
    public static function htmlTag($tag, $attributes, $contents="") {
        
        // Make attributes
        $attribute = "";
        if (count($attributes) > 0) {
            foreach ($attributes as $key => $value) {
                if (is_array($value)) {
                    $value = implode(" ", $value);
                }
                
                if (!empty($value)) {
                    $attribute .= $key . "='" . $value . "' ";
                }
            }
        }
        $attribute = trim($attribute, " ");
        
        // Start tag
        $html = "<$tag $attribute>";
        
        // Insert content
        $html .= $contents;
        
        // End tag
        if (!empty($contents) || $contents === "") {
            $html .= "</$tag>";
        }
        
        return $html;
        
    }
    
}

?>