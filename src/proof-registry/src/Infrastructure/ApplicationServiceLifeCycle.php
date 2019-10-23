<?php


namespace ProofRegistry\Infrastructure;


use Illuminate\Support\Facades\DB;
use ProofRegistry\Application\ApplicationServiceLifeCycle as IApplicationServiceLifeCycle;

class ApplicationServiceLifeCycle implements IApplicationServiceLifeCycle
{

    public function begin(): void
    {
        DB::beginTransaction();
    }

    public function success(): void
    {
        DB::commit();
    }

    public function fail(): void
    {
        DB::rollBack();
    }
}
