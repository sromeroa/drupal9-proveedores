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

/* themes/custom/bimboprov/templates/classy/field/views-view-fields.html.twig */
class __TwigTemplate_46a4e5c162e5c0695369c1f4fdc56794d32a4aed493114f17d817f996058ac5e extends \Twig\Template
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
        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["fields"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
            // line 33
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["field"], "separator", [], "any", false, false, true, 33), 33, $this->source), "html", null, true);
            // line 34
            if (twig_get_attribute($this->env, $this->source, $context["field"], "wrapper_element", [], "any", false, false, true, 34)) {
            }
            // line 36
            if (twig_get_attribute($this->env, $this->source, $context["field"], "label", [], "any", false, false, true, 36)) {
                // line 37
                if (twig_get_attribute($this->env, $this->source, $context["field"], "label_element", [], "any", false, false, true, 37)) {
                    // line 38
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["field"], "label", [], "any", false, false, true, 38), 38, $this->source), "html", null, true);
                } else {
                    // line 40
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["field"], "label", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["field"], "label_suffix", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                }
            }
            // line 43
            if (twig_get_attribute($this->env, $this->source, $context["field"], "element_type", [], "any", false, false, true, 43)) {
                // line 44
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["field"], "content", [], "any", false, false, true, 44), 44, $this->source), "html", null, true);
            } else {
                // line 46
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["field"], "content", [], "any", false, false, true, 46), 46, $this->source), "html", null, true);
            }
            // line 48
            if (twig_get_attribute($this->env, $this->source, $context["field"], "wrapper_element", [], "any", false, false, true, 48)) {
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "themes/custom/bimboprov/templates/classy/field/views-view-fields.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 48,  65 => 46,  62 => 44,  60 => 43,  55 => 40,  52 => 38,  50 => 37,  48 => 36,  45 => 34,  43 => 33,  39 => 32,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/bimboprov/templates/classy/field/views-view-fields.html.twig", "/repo/repo/n9/themes/custom/bimboprov/templates/classy/field/views-view-fields.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 32, "if" => 34);
        static $filters = array("escape" => 33);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
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
