<?php
// src/C2J/UserBundle/C2JUserBundle.php

namespace C2J\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class C2JUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}