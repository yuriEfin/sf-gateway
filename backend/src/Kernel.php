<?php

namespace App;


use App\CompillerPass\RouteHandlerCompilerPass;
use App\CompillerPass\RouteHandlerCompillerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
