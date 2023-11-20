<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tasks')]
class TaskController extends AbstractController
{
  #[Route('/', name: 'app_task_index', methods: ['GET'])]
  public function index(TaskRepository $taskRepository): Response
  {
    return $this->render('task/tasks.html.twig', [
      'tasks' => $taskRepository->findAll(),
    ]);
  }

  #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
  public function new(Request $request, EntityManagerInterface $entityManager): Response
  {
    $task = new Task();
    $form = $this->createForm(TaskType::class, $task);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $task->setCreatedAt(new \DateTimeImmutable());
      $task->setIsDone(false);
      $task->setUser($this->getUser());

      $entityManager->persist($task);
      $entityManager->flush();

      return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('task/new.html.twig', [
      'task' => $task,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
  public function show(Task $task): Response
  {
    return $this->render('task/show.html.twig', [
      'task' => $task,
    ]);
  }

  #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
  {
    $form = $this->createForm(TaskType::class, $task);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $task->setIsDone($task->isIsDone());
      $entityManager->persist($task);
      $entityManager->flush();

      return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('task/edit.html.twig', [
      'task' => $task,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_task_delete', methods: ['POST'])]
  public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
  {
    if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token'))) {
      $entityManager->remove($task);
      $entityManager->flush();
    }

    return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
  }

  #[Route('/{id}/toggle', name: 'task_toggle', methods: ['GET'])]
  public function taskToggle(Request $request, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response
  {
    $id = $request->query->get('id');
    $isDone = $request->query->get('isDone');
    $task = $taskRepository->find($id);
    $doneLabel = 'faite.';
    if ($isDone == 1) {
      $task->toggleTask(false);
    } else {
      $task->toggleTask(true);
      $doneLabel = 'à faire.';
    }

    $entityManager->persist($task);
    $entityManager->flush();

    return $this->json(
      $id
    );
  }
}
