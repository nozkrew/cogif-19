<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use Symfony\Component\String\Slugger\AsciiSlugger;
use App\Form\ArticleType;

class MainController extends AbstractController{
    
    /**
     * @Route("/")
     * @Route("/page/{num}", requirements={"num"="\d+"})
     */
    public function index(Request $request, $num = 1)
    {
        
        $articles = $this->getArtcileRepository()->findBy([
            'valid' => true
        ], [
            'id' => 'DESC'
        ], $this->getParameter('articles_by_page'), (($num-1)*10));
        
        $nb = $this->getArtcileRepository()->countArticles();
        $nbPages = ceil((int) $nb / $this->getParameter('articles_by_page'));
        
        return $this->render('main/index.html.twig', [
            'articles' => $articles,
            'next' => $num < $nbPages,
            'num' => $num
        ]);
    }
    
    /**
     * @Route("/{id}-{slug}", requirements={"id"="\d+"})
     */
    public function view($id, $slug){
        $article = $this->getArtcileRepository()->findOneBy([
            'id' => $id,
            'slug' => $slug,
            'valid' => true
        ]);
        
        if($article === null){
            throw $this->createNotFoundException();
        }
        
        return $this->render('main/view.html.twig', [
            'article' => $article,
        ]);
    }
    
    /**
     * @Route("/aleatoire")
     */
    public function random(){
        $article = $this->getArtcileRepository()->findRandom();
        
        return $this->redirect($this->generateUrl('app_main_view', array('id'=>$article->getId(), 'slug'=>$article->getSlug())));
    }
    
    /**
     * @Route("/ajouter")
     */
    public function add(Request $request){
        
        $article = new Article();
        
        $form = $this->createForm(ArticleType::class, $article);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add("success", "GIF enregistré. Il sera valider le plus rapidement possible");
                
                //S'il souhaite reposter
                if($form->get('postAndRepost')->isClicked()){
                    return $this->redirect($this->generateUrl('app_main_add'));
                }
                
                return $this->redirect($this->generateUrl('app_main_index'));
                
            } catch (Exception $ex) {
                //erreur
            }
        }
        
        return $this->render('main/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    private function getArtcileRepository(){
        return $this->getDoctrine()->getRepository(Article::class);
    }
}
