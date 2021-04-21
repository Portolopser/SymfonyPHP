<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleController extends AbstractController {
    /**
     * @Route("/", name="article_list")
     * @Method({"GET","POST"})
     */
        public function index(){
            $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
            return $this->render('articles/index.html.twig', array ('articles' => $articles));
        }

    /**
     * @Route("symphart/public/article/new", name="new_article")
     * Method({"GET", "POST"})
     * Con este método creamos un formulario que creará un artículo al introducir información.
     * 
     * Hacemos un createFormBuilder y creamos un input de texto, un textarea y un botón, cada uno con sus características.
     * 
     * Luego validamos que se ha enviado con el isSubmitted y el isValid, y con el entityManager creamos la consulta para 
     * que se cree en la base de datos.
     * 
     * Posteriormente con el redirectToRoute mostramos la página con el listado de artículos.
     */
        public function new(Request $request) {
            $article = new Article();

            $form = $this->createFormBuilder($article) 
            -> add('title', TextType::class, array('attr' => array('class' => 'form-control'))) 
            -> add('body', TextareaType::class, array(
                'required' => false, 
                'attr' => array('class' => 'form-control')
            ))
            -> add('save', SubmitType::class, array(
                'label' => 'Crear', 
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->IsValid()) {
                $article = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();

                return $this->redirectToRoute('article_list');
            }

            return $this->render('articles/new.html.twig', array(
                'form' => $form->createView()
            ));
        }

    /**
     * @Route("symphart/public/article/{id}", name="article_show")
     */

        public function show($id) {
            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
    
            return $this->render('articles/show.html.twig', array('article' => $article));
        }

    /**
     * Con esta ruta marcamos la direccion URL que queremos que haga la funcionalidad que escribimos
     * @Route("/article/save")
     */
    /* public function save() {
        //Creamos un Entity Manager y un objeto Article
        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();

        //Establecemos el título y el cuerpo del artículo que queramos
        $article->setTitle('Article Two');
        $article->setBody('This is the body for article two');

        $entityManager->persist($article);
        $entityManager->flush();
        return new Response('Saved an article with the id of '.$article->getId());
    } */
}
?>