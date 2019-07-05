<?php
declare(strict_types=1);

namespace App\Service;

interface PhotoStorageInterface {

    public function store(string $fileName);



}