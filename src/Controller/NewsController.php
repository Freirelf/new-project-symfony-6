<?php

namespace App\Controller;

use App\Entity\Main\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class NewsController extends BaseController
{
    #[Route('/admin/news', name: 'app_news')]
    public function index(NewsRepository $newsRepository): Response
    {   
        $entities = $newsRepository->findAll();
        return $this->render('news/index.html.twig', [
            'entities' => $entities,
            'activeMenu' => 'news',
        ]);
    }

    #[Route('/admin/news/{id}/edit', name: 'app_news_edit')]
    public function edit(Request $request, News $news, NewsRepository $newsRepository)
    {   
        $oldEntity = $newsRepository->find($news->getId());
        $oldFile = $oldEntity->getImage();

        $form = $this->createForm( NewsType::class, $news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['image']->getData();
            if ($file) {
                
                if ($oldFile != "") {
                    $filesystem = new Filesystem();
                    if ($filesystem->exists('image/'.$oldFile)) {
                        $filesystem->remove(['image/'.$oldFile]); 
                    }
                }
               
                $someNewFilename = uniqid();

                $extension = $file->guessExtension();
                if (!$extension) {
                    $extension = 'jpg';
                }

                $someNewFilename = $someNewFilename.'.'.$extension;

                $file->move('image', $someNewFilename);
                $news->setImage($someNewFilename);
            }

            $newsRepository->save($news, true);
            $this->addFlash('success', 'news.edit.success');
            return $this->redirectToRoute('app_news');
        }
        return $this->render('news/edit.html.twig', [
            'activeMenu' => 'news',
            'news' => $news,
            'form' => $form
        ]);
    }

    #[Route('/admin/news/new', name: 'app_news_new')]
    public function new(Request $request, NewsRepository $newsRepository)
    {   
        $news = new News();
        $form = $this->createForm( NewsType::class, $news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['image']->getData();
            if ($file) {
 
                $someNewFilename = uniqid();

                $extension = $file->guessExtension();
                if (!$extension) {
                    $extension = 'jpg';
                }

                $someNewFilename = $someNewFilename.'.'.$extension;

                $file->move('image', $someNewFilename);
                $news->setImage($someNewFilename);
            }

            $newsRepository->save($news, true);
            $this->addFlash('success', 'news.edit.success');
            return $this->redirectToRoute('app_news');
        }
        return $this->render('news/new.html.twig', [
            'activeMenu' => 'news',
            'news' => $news,
            'form' => $form
        ]);
    }

    #[Route('/admin/news/{id}/delete', name: 'app_news_delete', methods: ['POST'])]
    public function delete(Request $request, News $news, NewsRepository $newsRepository)
    {   
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {

                    if ($news->getImage() != "") {
                    $filesystem = new Filesystem();
                    if ($filesystem->exists('image/'.$news->getImage())) {
                        $filesystem->remove(['image/'.$news->getImage()]); 
                    }
                }

            $newsRepository->remove($news, true);
            $this->addFlash('success', 'news.delete.success');
        }
        return $this->redirectToRoute('app_news');
    }
}
