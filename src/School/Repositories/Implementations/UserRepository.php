<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\User;
use App\School\Repositories\Interfaces\IUserRepository;
use PDO;

class UserRepository implements IUserRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function add(User $user): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (first_name, last_name, email, password, user_type)
            VALUES (:first_name, :last_name, :email, :password, :user_type)
        ");

        $stmt->bindValue(':first_name', $user->getFirstName());
        $stmt->bindValue(':last_name', $user->getLastName());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', password_hash($user->getPassword(), PASSWORD_DEFAULT)); // Cifrar la contraseña
        $stmt->bindValue(':user_type', $user->getUserType());
        $stmt->execute();

        $user->setId((int)$this->db->lastInsertId());
    }

    public function update(User $user): void
    {
        $stmt = $this->db->prepare("
            UPDATE users SET 
                first_name = :first_name,
                last_name = :last_name,
                email = :email,
                password = :password,
                user_type = :user_type
            WHERE id = :id
        ");

        $stmt->bindValue(':id', $user->getId());
        $stmt->bindValue(':first_name', $user->getFirstName());
        $stmt->bindValue(':last_name', $user->getLastName());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', password_hash($user->getPassword(), PASSWORD_DEFAULT)); // Cifrar la contraseña
        $stmt->bindValue(':user_type', $user->getUserType());
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToUser($data) : null;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToUser'], $users);
    }

    private function mapToUser(array $data): User
    {

        $user = new User(
            $data['first_name'] ?? '', // Si no existe, asigna cadena vacía
            $data['last_name'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? '',
            $data['user_type'] ?? ''
        );

        $user->setId((int) ($data['id'] ?? 0)); // Si no existe, asigna 0

        return $user;
    }
}
