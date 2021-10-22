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

/* themes/custom/bimboprov/templates/menu--extras--footer--redes-sociales--footer-first.html.twig */
class __TwigTemplate_4abb1cb28f01ca999aebf94135711db51a01e922a394c86ec9ac361bcaf629ae extends \Twig\Template
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
        // line 7
        $macros["menu"] = $this->macros["menu"] = $this;
        // line 8
        echo "
";
        // line 9
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["menu"], "macro_menu_links", [($context["items"] ?? null), ($context["attributes"] ?? null), 0], 9, $context, $this->getSourceContext()));
        echo "

";
    }

    // line 11
    public function macro_menu_links($__items__ = null, $__attributes__ = null, $__menu_level__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "items" => $__items__,
            "attributes" => $__attributes__,
            "menu_level" => $__menu_level__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 12
            echo "  <ul";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => "c-footer__redes-menu"], "method", false, false, true, 12), 12, $this->source), "html", null, true);
            echo ">
  ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                if ((twig_first($this->env, $context["key"]) != "#")) {
                    // line 14
                    echo "    ";
                    $context["menu_item_classes"] = [0 => "c-footer__redes-item", 1 => ((twig_get_attribute($this->env, $this->source,                     // line 16
$context["item"], "is_expanded", [], "any", false, false, true, 16)) ? ("menu-item--expanded") : ("")), 2 => ((twig_get_attribute($this->env, $this->source,                     // line 17
$context["item"], "is_collapsed", [], "any", false, false, true, 17)) ? ("menu-item--collapsed") : ("")), 3 => ((twig_get_attribute($this->env, $this->source,                     // line 18
$context["item"], "in_active_trail", [], "any", false, false, true, 18)) ? ("menu-item--active-trail") : (""))];
                    // line 20
                    echo "
    <li";
                    // line 21
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 21), "addClass", [0 => ($context["menu_item_classes"] ?? null)], "method", false, false, true, 21), 21, $this->source), "html", null, true);
                    echo ">
      ";
                    // line 22
                    if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "span", [], "any", false, false, true, 22), "class", [], "any", false, false, true, 22)) > 0)) {
                        echo "  
        <a href=\"";
                        // line 23
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 23), 23, $this->source), "html", null, true);
                        echo "\" class=\"c-footer__redes-item-link\"><span class=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "span", [], "any", false, false, true, 23), "class", [], "any", false, false, true, 23), 23, $this->source), "html", null, true);
                        echo "\"></span></a>
      ";
                    } else {
                        // line 25
                        echo "        <a href=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
                        echo "\" class=\"c-footer__redes-text\">";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
                        echo "</a>
      ";
                    }
                    // line 27
                    echo "      ";
                    $context["rendered_content"] = $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "content", [], "any", false, false, true, 27), 27, $this->source), "");
                    // line 28
                    echo "      ";
                    if ($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["rendered_content"] ?? null))) {
                        // line 29
                        echo "        ";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["rendered_content"] ?? null), 29, $this->source), "html", null, true);
                        echo "
      ";
                    }
                    // line 31
                    echo "    </li>
  ";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 33
            echo "  </ul>
";

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "themes/custom/bimboprov/templates/menu--extras--footer--redes-sociales--footer-first.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  128 => 33,  120 => 31,  114 => 29,  111 => 28,  108 => 27,  100 => 25,  93 => 23,  89 => 22,  85 => 21,  82 => 20,  80 => 18,  79 => 17,  78 => 16,  76 => 14,  71 => 13,  66 => 12,  51 => 11,  44 => 9,  41 => 8,  39 => 7,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/bimboprov/templates/menu--extras--footer--redes-sociales--footer-first.html.twig", "/repo/repo/n9/themes/custom/bimboprov/templates/menu--extras--footer--redes-sociales--footer-first.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("import" => 7, "macro" => 11, "for" => 13, "set" => 14, "if" => 22);
        static $filters = array("escape" => 12, "first" => 13, "length" => 22, "without" => 27, "render" => 28);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['import', 'macro', 'for', 'set', 'if'],
                ['escape', 'first', 'length', 'without', 'render'],
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
