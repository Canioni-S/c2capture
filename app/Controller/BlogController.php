<?php

namespace App\Controller;

class BlogController extends AppController
{
    public function aboutMe()
    {
        $title = "Qui_suis-je?";
        $extraCss = "aboutMe";
        $this->render("blog.aboutMe", compact("title", "extraCss"));
    }

    public function contact()
    {
        $title = "Contact";
        $extraCss = "form";
        $this->render("blog.contact", compact("title", "extraCss"));
    }

    public function legalMention()
    {
        $title = "Mentions legales";
        $extraCss = "legal";
        $this->render("blog.legalMention", compact("title", "extraCss"));
    }

    public function prestation()
    {
        $title = "Prestations";
        $extraCss = "prestation";
        $this->render("blog.prestation", compact("title", "extraCss"));
    }
}
