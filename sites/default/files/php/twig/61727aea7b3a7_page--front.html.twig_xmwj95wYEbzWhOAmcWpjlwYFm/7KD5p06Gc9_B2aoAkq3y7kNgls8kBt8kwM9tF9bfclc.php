<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/custom/bimboprov/templates/page--front.html.twig */
class __TwigTemplate_498f9094c7a3f2f7bc377e475a5affd14bf9b34a4fe89d59ab54ed344dd3b8c3 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 53
        echo "

<div class=\"page o-center-page__page\">

  ";
        // line 57
        if (($context["logged_in"] ?? null)) {
            // line 58
            echo "  <div class=\"c-wrapper container\">
    <div class=\"c-header-aside js-header-aside\">
      <div class=\"c-header-aside__container\">
        <div class=\"c-header-aside__mobile\"><a class=\"c-header-aside__mobile-link js-close-menu\" href=\"#\" title=\"Menú hamburguesa\"> <span class=\"c-header-aside__mobile-icon icon cerrar\"></span></a></div>
        <div class=\"c-header-aside__logo\"><a class=\"c-header-aside__logo-link\" href=\"/\" title=\"Grupo Bimbo\"> <img class=\"\" src=\"https://bmbprov.s3.us-west-2.amazonaws.com/s3fs-public/2021-05/Grupo-Bimbo-Proveedores-Logo.png\" data-src=\"https://bmbprov.s3.us-west-2.amazonaws.com/s3fs-public/2021-05/Grupo-Bimbo-Proveedores-Logo.png\" alt=\"Logo Grupo Bimbo\"></a></div>
        <nav class=\"c-header-aside__menu menu-secundario\">
          ";
            // line 64
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 64), 64, $this->source), "html", null, true);
            echo "
        </nav>
        <div class=\"c-header__menu c-header__menu--submenu\">
          ";
            // line 67
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 67), 67, $this->source), "html", null, true);
            echo "
        </div>
      </div>
    </div>
    <div class=\"c-wrapper__contenido\">
      <header class=\"c-header\">
        <div class=\"c-header__container container\">
          <div class=\"c-header__logo\"><a class=\"c-header__logo-link\" href=\"";
            // line 74
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 74, $this->source), "html", null, true);
            echo "\" title=\"Grupo Bimbo\"> <img class=\"lazy\" src=\"#\" data-src=\"https://bmbprov.s3.us-west-2.amazonaws.com/s3fs-public/2021-05/Grupo-Bimbo-Proveedores-Logotipo.png\" alt=\"Logo Grupo Bimbo\"></a></div>
          <div class=\"c-header__menu\">
            ";
            // line 76
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 76), 76, $this->source), "html", null, true);
            echo "
          </div>
          <div class=\"c-header__mobile\"><a class=\"c-header__mobile-link js-open-menu\" href=\"#\" title=\"Menú hamburguesa\"> <span class=\"c-header__mobile-icon icon burger\"></span></a></div>
        </div>
      </header>
      <main class=\"c-main\">
        <div class=\"container\">
          ";
            // line 83
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 83), 83, $this->source), "html", null, true);
            echo "  
        </div>
      </main>
    </div>
  </div>  
    ";
            // line 88
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "aftercontent", [], "any", false, false, true, 88), 88, $this->source), "html", null, true);
            echo "
  ";
        } else {
            // line 89
            echo "      
  <header class=\"c-header-language\">
    <div class=\"container\">
      <div class=\"c-header-language__container\">
        
        <div class=\"c-header-language__logo\">
          <a class=\"c-header-language__logo-link\" href=\"";
            // line 95
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 95, $this->source), "html", null, true);
            echo "\" title=\"Grupo Bimbo\">
            <img class=\"lazy\" src=\"//bmbprov.s3.us-west-2.amazonaws.com/s3fs-public/2021-05/Grupo-Bimbo-Proveedores-Logotipo.png\" data-src=\"//bmbprov.s3.us-west-2.amazonaws.com/s3fs-public/2021-05/Grupo-Bimbo-Proveedores-Logotipo.png\" alt=\"Logo Grupo Bimbo\">
          </a>
        </div>

        <div class=\"c-header-language__menu\">
          <ul class=\"c-header-language__idioma\">
            <li class=\"c-header-language__idioma-item\"><a class=\"c-header-language__idioma-item-link is-active\" href=\"";
            // line 102
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 102, $this->source), "html", null, true);
            echo "es\" title=\"Español\">ES</a></li>
            <li class=\"c-header-language__idioma-item\"><a class=\"c-header-language__idioma-item-link\" href=\"";
            // line 103
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 103, $this->source), "html", null, true);
            echo "en\" title=\"English\">EN</a></li>
          </ul>
        </div>

      </div>
    </div>
  </header>      
  <main class=\"o-center-page__main\">
        ";
            // line 111
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 111), 111, $this->source), "html", null, true);
            echo "          
  </main>
  ";
        }
        // line 114
        echo "
  <footer class=\"c-footer\">
    <div class=\"container\">
      <div class=\"c-footer__container\">
        <div class=\"c-footer__redes\">
          ";
        // line 119
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 119), 119, $this->source), "html", null, true);
        echo "
        </div>
        <div class=\"c-footer__legal\">
          ";
        // line 122
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 122), 122, $this->source), "html", null, true);
        echo "
        </div>
      </div>
    </div>
  </footer>  

</div>";
    }

    public function getTemplateName()
    {
        return "themes/custom/bimboprov/templates/page--front.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  151 => 122,  145 => 119,  138 => 114,  132 => 111,  121 => 103,  117 => 102,  107 => 95,  99 => 89,  94 => 88,  86 => 83,  76 => 76,  71 => 74,  61 => 67,  55 => 64,  47 => 58,  45 => 57,  39 => 53,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/bimboprov/templates/page--front.html.twig", "/repo/repo/n9/themes/custom/bimboprov/templates/page--front.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 57);
        static $filters = array("escape" => 64);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
