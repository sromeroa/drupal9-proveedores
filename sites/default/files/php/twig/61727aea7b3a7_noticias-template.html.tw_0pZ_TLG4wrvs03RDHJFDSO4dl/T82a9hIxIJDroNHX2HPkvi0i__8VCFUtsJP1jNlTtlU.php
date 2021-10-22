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

/* modules/custom/bm_noticias/templates/noticias-template.html.twig */
class __TwigTemplate_baae44b918b68a6cf049cbc507bd1401436cf77c13a5bc731273fea890fec36d extends \Twig\Template
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
        echo "<section class=\"c-noticias-ultimas\">
\t<div class=\"c-subtitle c-subtitle--row-align\">
\t\t<div class=\"c-subtitle__head\">
\t\t\t<h2 class=\"c-subtitle__head-titulo\">";
        // line 4
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Últimas noticias"));
        echo "</h2>
\t\t</div>
\t\t<div class=\"c-subtitle__boton\"></div>
\t</div>
\t<div class=\"c-noticias__container\">
\t\t<ul class=\"c-noticias__lista js-slider-noticias\">
\t\t\t";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["noticias"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["noticia"]) {
            // line 11
            echo "\t\t\t\t";
            if (twig_get_attribute($this->env, $this->source, $context["noticia"], "fecha", [], "any", false, false, true, 11)) {
                // line 12
                echo "\t\t\t\t\t<li class=\"c-noticias__lista-item\">
\t\t\t\t\t\t<div class=\"c-tarjeta c-tarjeta--noticias\">
\t\t\t\t\t\t\t<div class=\"c-tarjeta__imagen\">
\t\t\t\t\t\t\t\t<a class=\"c-tarjeta__imagen-link\" href=\"";
                // line 15
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "noticiaId", [], "any", false, false, true, 15), 15, $this->source), "html", null, true);
                echo "\" title=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "titulo", [], "any", false, false, true, 15), 15, $this->source), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t<img class=\"c-tarjeta__imagen-img\" src=\"";
                // line 16
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "imagen", [], "any", false, false, true, 16), 16, $this->source), "html", null, true);
                echo "\" data-src=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "imagen", [], "any", false, false, true, 16), 16, $this->source), "html", null, true);
                echo "\" alt=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "titulo", [], "any", false, false, true, 16), 16, $this->source), "html", null, true);
                echo "\"></a>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"c-tarjeta__texto\">
\t\t\t\t\t\t\t\t<h3>
\t\t\t\t\t\t\t\t\t<a class=\"c-tarjeta__texto-link\" href=\"";
                // line 20
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "noticiaId", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
                echo "\" title=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "titulo", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
                echo "\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "titulo", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
                echo "</a>
\t\t\t\t\t\t\t\t</h3>
\t\t\t\t\t\t\t\t<p>";
                // line 22
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "subtitulo", [], "any", false, false, true, 22), 22, $this->source), "html", null, true);
                echo "</p>
\t\t\t\t\t\t\t\t<a class=\"btn btn-circulo c-tarjeta__boton-flotante\" href=\"";
                // line 23
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "noticiaId", [], "any", false, false, true, 23), 23, $this->source), "html", null, true);
                echo "\" title=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["noticia"], "titulo", [], "any", false, false, true, 23), 23, $this->source), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t<span class=\"icon anexar\"></span>
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</li>
\t\t\t\t";
            }
            // line 30
            echo "\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['noticia'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "\t\t</ul>
\t</div>
\t<div class=\"c-noticias__boton u-text-right\">
\t\t<a class=\"c-noticias__link\" href=\"novedad-y-comunicacion\" title=\"ver todas las noticias\">";
        // line 34
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("ver todas las noticias"));
        echo "</a>
\t</div>
</section>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/bm_noticias/templates/noticias-template.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 34,  113 => 31,  107 => 30,  95 => 23,  91 => 22,  82 => 20,  71 => 16,  65 => 15,  60 => 12,  57 => 11,  53 => 10,  44 => 4,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/bm_noticias/templates/noticias-template.html.twig", "/repo/repo/n9/modules/custom/bm_noticias/templates/noticias-template.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 10, "if" => 11);
        static $filters = array("t" => 4, "escape" => 15);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
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
