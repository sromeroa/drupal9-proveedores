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

/* modules/custom/bm_programas/templates/programas-template.html.twig */
class __TwigTemplate_28d5e909095f5cc528b8e9d93dc5b77ae728eee771cfde181020ab7a0362fb65 extends \Twig\Template
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
        // line 1
        echo "<section class=\"c-noticias-programas\">
\t<div class=\"c-subtitle\">
\t\t<div class=\"c-subtitle__head\">
\t\t\t<h2 class=\"c-subtitle__head-titulo\">";
        // line 4
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Programas"));
        echo "</h2>
\t\t</div>
\t\t<div class=\"c-subtitle__texto\">
\t\t\t<p class=\"c-subtitle__texto-descripcion\">";
        // line 7
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Herramientas de apoyo para nuestros proveedores"));
        echo "</p>
\t\t</div>
\t</div>
\t<div class=\"c-noticias__container\">
\t\t<ul class=\"c-noticias__lista c-noticias__lista--programas\">
\t\t\t";
        // line 12
        $context["count"] = 0;
        // line 13
        echo "\t\t\t";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["programas"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["programa"]) {
            // line 14
            echo "\t\t\t\t";
            if (twig_get_attribute($this->env, $this->source, $context["programa"], "programaId", [], "any", false, false, true, 14)) {
                // line 15
                echo "\t\t\t\t\t";
                $context["count"] = (($context["count"] ?? null) + 1);
                // line 16
                echo "\t\t\t\t\t";
                if ((($context["count"] ?? null) <= 3)) {
                    // line 17
                    echo "\t\t\t\t\t\t<li class=\"c-noticias__lista-item\">
\t\t\t\t\t\t\t<div class=\"c-tarjeta c-tarjeta--small\">
\t\t\t\t\t\t\t\t<div class=\"c-tarjeta__imagen\">
\t\t\t\t\t\t\t\t\t<a class=\"c-tarjeta__imagen-link\" href=\"";
                    // line 20
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["programa"], "programaId", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
                    echo "\" title=\"";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["programa"], "titulo", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
                    echo "\">
\t\t\t\t\t\t\t\t\t\t<img class=\"c-tarjeta__imagen-img\" src=\"";
                    // line 21
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["programa"], "imagen", [], "any", false, false, true, 21), 21, $this->source), "html", null, true);
                    echo "\" data-src=\"";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["programa"], "imagen", [], "any", false, false, true, 21), 21, $this->source), "html", null, true);
                    echo "\" alt=\"";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["programa"], "titulo", [], "any", false, false, true, 21), 21, $this->source), "html", null, true);
                    echo "\"></a>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"c-tarjeta__texto\">
\t\t\t\t\t\t\t\t\t<h4 class=\"c-tarjeta__titulo c-tarjeta__titulo--small o-font-roboto\">
\t\t\t\t\t\t\t\t\t\t<a class=\"c-tarjeta__texto-link\" href=\"";
                    // line 25
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["programa"], "programaId", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
                    echo "\" title=\"";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["programa"], "titulo", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
                    echo "\">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["programa"], "titulo", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
                    echo ".</a>
\t\t\t\t\t\t\t\t\t</h4>
\t\t\t\t\t\t\t\t\t<a class=\"o-btn__enlace-link\" href=\"";
                    // line 27
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["programa"], "programaId", [], "any", false, false, true, 27), 27, $this->source), "html", null, true);
                    echo "\" title=\"";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Conoce los detalles"));
                    echo " \">
\t\t\t\t\t\t\t\t\t\t<span class=\"o-btn__enlace-icon icon leer-mas\"></span>
\t\t\t\t\t\t\t\t\t\t";
                    // line 29
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Conoce los detalles"));
                    echo "</a>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</li>
\t\t\t\t\t";
                }
                // line 34
                echo "\t\t\t\t";
            }
            // line 35
            echo "\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['programa'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 36
        echo "\t\t</ul>

\t</div>

\t";
        // line 40
        if ((($context["count"] ?? null) >= 4)) {
            // line 41
            echo "\t\t<div class=\"c-noticias__boton u-text-right\">
\t\t\t<a class=\"c-noticias__link\" href=\"programas\" title=\"ver todas las noticias\">ver todas los programas</a>
\t\t</div>
\t";
        }
        // line 45
        echo "</section>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/bm_programas/templates/programas-template.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  143 => 45,  137 => 41,  135 => 40,  129 => 36,  123 => 35,  120 => 34,  112 => 29,  105 => 27,  96 => 25,  85 => 21,  79 => 20,  74 => 17,  71 => 16,  68 => 15,  65 => 14,  60 => 13,  58 => 12,  50 => 7,  44 => 4,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/bm_programas/templates/programas-template.html.twig", "/repo/repo/n9/modules/custom/bm_programas/templates/programas-template.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 12, "for" => 13, "if" => 14);
        static $filters = array("t" => 4, "escape" => 20);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'for', 'if'],
                ['t', 'escape'],
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
