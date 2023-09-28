<?php

// src/Controller/GroupsController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Groups;

class GroupsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/api/groups", name="api_groups_get", methods={"GET"})
     */
    public function getGroups()
    {
        $groups = $this->entityManager->getRepository(Groups::class)->findAll();

        $arrayOfGroups = [];
        foreach ($groups as $group) {
            $arrayOfGroups[] = [
                'id' => $group->getId(),
                'name' => $group->getName(),
                'products' => $group->getProducts(),
            ];
        }

        return $this->json($arrayOfGroups);
    }

    /**
     * @Route("/api/groups", name="api_groups_post", methods={"POST"})
     */
    public function createGroup(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $products = $data['products'];

        $validator = Validation::createValidator();
        $violationsName = $validator->validate($name, [
            new Length([
                'min' => 3,
                'minMessage' => 'El campo "name" debe tener al menos {{ limit }} caracteres.',
            ]),
            new NotBlank([
                'message' => 'El campo "name" no puede estar vacío.',
            ]),
        ]);

        $violationsProducts = $validator->validate($products, [
            new NotBlank([
                'message' => 'El campo "products" no puede estar vacío.',
            ]),
        ]);

        if (count($violationsName) > 0 || count($violationsProducts) > 0) {
            $errors = [];
            foreach ($violationsName as $violation) {
                $errors[] = $violation->getMessage();
            }
            foreach ($violationsProducts as $violation) {
                $errors[] = $violation->getMessage();
            }

            return new JsonResponse(['errors' => $errors], 400);
        }

        $group = new Groups();
        $group->setName($name);
        $group->setProducts($products);

        $this->entityManager->persist($group);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Grupo creado correctamente']);
    }

    /**
     * @Route("/api/groups/{id}", name="api_groups_put", methods={"PUT"})
     */

    public function updateGroup(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);

        $group = $this->entityManager->getRepository(Groups::class)->findOneBy(['id' => $id]);

        if (!$group) {
            return new JsonResponse(['error' => 'Grupo no encontrado'], 404);
        }

        $name = $data['name'] ?? null;
        $products = $data['products'] ?? null;

        $validator = Validation::createValidator();
        $violationsName = [];
        $violationsProducts = [];

        if ($name) {
            $violationsName = $validator->validate($name, [
                new Length([
                    'min' => 3,
                    'minMessage' => 'El campo "name" debe tener al menos {{ limit }} caracteres.',
                ]),
                new NotBlank([
                    'message' => 'El campo "name" no puede estar vacío.',
                ]),
            ]);
        }

        if ($products) {
            $violationsProducts = $validator->validate($products, [
                new NotBlank([
                    'message' => 'El campo "products" no puede estar vacío.',
                ]),
            ]);
        }

        if (count($violationsName) > 0 || count($violationsProducts) > 0) {
            $errors = [];
            foreach ($violationsName as $violation) {
                $errors[] = $violation->getMessage();
            }
            foreach ($violationsProducts as $violation) {
                $errors[] = $violation->getMessage();
            }

            return new JsonResponse(['errors' => $errors], 400);
        }

        if ($name)
            $group->setName($name);
        if ($products)
            $group->setProducts($products);

        $this->entityManager->persist($group);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Grupo actualizado correctamente']);
    }

    /**
     * @Route("/api/groups/{id}", name="api_groups_delete", methods={"DELETE"})
     */
    public function deleteGroup($id)
    {
        $group = $this->entityManager->getRepository(Groups::class)->findOneBy(['id' => $id]);

        if (!$group) {
            return new JsonResponse(['error' => 'Grupo no encontrado'], 404);
        }

        $this->entityManager->remove($group);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Grupo eliminado correctamente']);
    }
}
