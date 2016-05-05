<?php

\Croogo\Core\Croogo::hookComponent('Croogo/Nodes.Nodes', ['FeaturedImage.FeaturedImage' => ['priority' => 5]]);
\Croogo\Core\Croogo::hookComponent('Croogo/Nodes.Admin/Nodes', ['FeaturedImage.FeaturedImage' => ['priority' => 5]]);
\Croogo\Core\Croogo::hookBehavior('Croogo/Nodes.Nodes', 'FeaturedImage.FeaturedImage');
\Croogo\Core\Croogo::hookHelper('Croogo/Nodes.Admin/Nodes', 'Croogo/Core.Image');
