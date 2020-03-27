<?php

namespace App\Entity\Listener;

use App\Entity\Article;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ArticleListener {
    
    /** @PrePersist */
    public function prePersistHandler(Article $article, LifecycleEventArgs $event) {
        
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($article->getTitle())->lower();
        
        $article->setSlug($slug);
    }
}
