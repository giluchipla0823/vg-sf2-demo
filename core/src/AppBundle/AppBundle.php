<?php

namespace AppBundle;

use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $definition = new DefinitionDecorator('custom.security.authentication.listener.form');
        $definition->setClass('AppBundle\EventListener\UsernamePasswordFormAuthenticationListener');
        $definition->setAbstract(true);

        $container->setDefinition('security.authentication.listener.form', $definition);
    }
}
