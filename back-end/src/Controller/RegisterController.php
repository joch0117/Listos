<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function __invoke(
        Request $request,
        EntityManagerInterface $em,
        UserService $us,
        ValidatorInterface $validator,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        /// vérif unicité mot de passe 
        if (!$us->isEmailUnique($data['email'] ?? '')) {
            return new JsonResponse(['error' => 'Cet email est déjà utilisé.'], 400);
        }

        $user = new User();
        $user->setEmail($data['email'] ?? '');
        $user->setPseudo($data['pseudo'] ?? '');
        $user->setName($data['name'] ?? '');
        $user->setSurname($data['prenom'] ?? '');
        $user->setRoles(['ROLE_USER']);
        $user->setPlainPassword($data['plainPassword'] ?? '');

        //  Hasher le password
        if (empty($data['plainPassword'])) {
            return new JsonResponse(['error' => 'Mot de passe obligatoire'], 400);
        }
        $hashed = $us->hashPassword($user, $data['plainPassword']);
        $user->setPassword($hashed);

        $errors = $validator->validate($user, null, ['registration']);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => (string) $errors], 400);
        }
        
        try{
        $em->persist($user);
        $em->flush();
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Erreur serveur ou base de données :' . $e->getMessage()
            ],500);
        }

        $token = $jwtManager->create($user);

        return new JsonResponse([
            'message' => 'Utilisateur créé !',
            'token' => $token
            ], 201);
    }
}
