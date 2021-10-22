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

/* themes/custom/bimboprov/templates/page--user--login.html.twig */
class __TwigTemplate_a479a02d92926783c594e4d67fdd2e90eb431caa7b22d8dd14b0288b241a81d3 extends \Twig\Template
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
        echo "<div class=\"page o-center-page__page\">

      <header class=\"c-header-language\">
        <div class=\"container\">
          <div class=\"c-header-language__container\">
            
            <div class=\"c-header-language__logo\">
              <a class=\"c-header-language__logo-link\" href=\"";
        // line 60
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 60, $this->source), "html", null, true);
        echo "\" title=\"Grupo Bimbo\">
                <img class=\"lazy\" src=\"//bmbprov.s3.us-west-2.amazonaws.com/s3fs-public/2021-05/Grupo-Bimbo-Proveedores-Logotipo.png\" data-src=\"//bmbprov.s3.us-west-2.amazonaws.com/s3fs-public/2021-05/Grupo-Bimbo-Proveedores-Logotipo.png\" alt=\"Logo Grupo Bimbo\">
              </a>
            </div>

            <div class=\"c-header-language__menu\">
              <ul class=\"c-header-language__idioma\">
                <li class=\"c-header-language__idioma-item\"><a class=\"c-header-language__idioma-item-link is-active\" href=\"";
        // line 67
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 67, $this->source), "html", null, true);
        echo "es\" title=\"Español\">ES</a></li>
                <li class=\"c-header-language__idioma-item\"><a class=\"c-header-language__idioma-item-link\" href=\"";
        // line 68
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 68, $this->source), "html", null, true);
        echo "en\" title=\"English\">EN</a></li>
              </ul>
            </div>

          </div>
        </div>
      </header>

      <main class=\"u-flex-grow u-align-items-center\">
        <section class=\"c-form\">
          <div class=\"container\">
            <div class=\"c-breadcrumbs\">
              <ul class=\"c-breadcrumbs__menu\">
                <li class=\"c-breadcrumbs__menu-item\"><a class=\"c-breadcrumbs__menu-item-link\" href=\"";
        // line 81
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 81, $this->source), "html", null, true);
        echo "\" title=\"Home\">Home</a></li>
                <li class=\"c-breadcrumbs__menu-item\"><span>Iniciar Sesion</span></li>
              </ul>
            </div>
          </div>
          <div class=\"container\">
            <div class=\"c-form__container\">
              <div class=\"c-form__content-title u-text-center\">
                <h1 class=\"c-form__titulo h1-montserrat\">Iniciar sesi&oacute;n</h1>
                <p>Si ya eres proveedor de Grupo Bimbo ingresa tus datos</p>
              </div>
              <div class=\"c-form__content-form\">
              ";
        // line 93
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 93), 93, $this->source), "html", null, true);
        echo "
              </div>
            </div>
          </div>
        </section>
      </main>

      <footer class=\"c-footer\">
      <div class=\"container\">
        <div class=\"c-footer__container\">
          <div class=\"c-footer__redes\">
            ";
        // line 104
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 104), 104, $this->source), "html", null, true);
        echo "
          </div>
          <div class=\"c-footer__legal\">
            ";
        // line 107
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 107), 107, $this->source), "html", null, true);
        echo "
          </div>
        </div>
      </div>
    </footer>       
</div>";
    }

    public function getTemplateName()
    {
        return "themes/custom/bimboprov/templates/page--user--login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  113 => 107,  107 => 104,  93 => 93,  78 => 81,  62 => 68,  58 => 67,  48 => 60,  39 => 53,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/bimboprov/templates/page--user--login.html.twig", "/repo/repo/n9/themes/custom/bimboprov/templates/page--user--login.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 60);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
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
