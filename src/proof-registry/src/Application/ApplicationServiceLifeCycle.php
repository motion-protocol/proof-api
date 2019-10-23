<?php


namespace ProofRegistry\Application;


interface ApplicationServiceLifeCycle
{
    public function begin(): void;
    public function success(): void;
    public function fail(): void;
}
