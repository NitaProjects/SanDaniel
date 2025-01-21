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
        $stmt->bindValue(':password', $user->getPassword()); 
        $stmt->bindValue(':user_type', $user->getUserType());
        $stmt->execute();

        $user->setId((int)$this->db->lastInsertId());
    }

    public function update(User $user): void
    {
        $query = "
            UPDATE users SET 
                first_name = :first_name,
                last_name = :last_name,
                email = :email,
                user_type = :user_type
        ";

        // Agregar campo de contraseña solo si es necesario
        if (!empty($user->getPassword())) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $user->getId());
        $stmt->bindValue(':first_name', $user->getFirstName());
        $stmt->bindValue(':last_name', $user->getLastName());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':user_type', $user->getUserType());

        if (!empty($user->getPassword())) {
            $stmt->bindValue(':password', $user->getPassword());
        }

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
        if (empty($data['id']) || empty($data['email']) || empty($data['user_type'])) {
            throw new \RuntimeException("Datos insuficientes para mapear a un usuario");
        }

        $user = new User(
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            $data['email'],
            $data['password'] ?? '', 
            $data['user_type']
        );

        $user->setId((int)$data['id']);
        return $user;
    }
}
