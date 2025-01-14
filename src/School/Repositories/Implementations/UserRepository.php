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

    public function save(User $user): void
    {
        if ($user->getId()) {
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
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO users (first_name, last_name, email, password, user_type)
                VALUES (:first_name, :last_name, :email, :password, :user_type)
            ");
        }

        $stmt->bindValue(':first_name', $user->getFirstName());
        $stmt->bindValue(':last_name', $user->getLastName());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':user_type', $user->getUserType());
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

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToUser($data) : null;
    }

    public function findByUserType(string $userType): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_type = :user_type");
        $stmt->bindValue(':user_type', $userType);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToUser'], $users);
    }

    public function findByName(string $firstName, string $lastName): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE first_name = :first_name AND last_name = :last_name
        ");
        $stmt->bindValue(':first_name', $firstName);
        $stmt->bindValue(':last_name', $lastName);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToUser'], $users);
    }

    public function findByCriteria(array $criteria): array
    {
        $query = "SELECT * FROM users WHERE 1=1";
        $params = [];

        foreach ($criteria as $key => $value) {
            $query .= " AND {$key} = :{$key}";
            $params[":{$key}"] = $value;
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToUser'], $users);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
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
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['password'],
            $data['user_type']
        );
        $user->setId($data['id']);
        return $user;
    }
}
