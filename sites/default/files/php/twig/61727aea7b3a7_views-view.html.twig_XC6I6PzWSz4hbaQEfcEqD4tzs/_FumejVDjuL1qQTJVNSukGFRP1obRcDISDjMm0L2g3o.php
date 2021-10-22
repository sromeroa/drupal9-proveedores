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

/* themes/custom/bimboprov/templates/classy/views/views-view.html.twig */
class __TwigTemplate_404bd9fdd07415f3a3662c5516460bdb79f98173dfd2fcc66758f3133b934856 extends \Twig\Template
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
        // line 34
        $context["classes"] = [0 => "view", 1 => ("view-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(        // line 36
($context["id"] ?? null), 36, $this->source))), 2 => ("view-id-" . $this->sandbox->ensureToStringAllowed(        // line 37
($context["id"] ?? null), 37, $this->source)), 3 => ("view-display-id-" . $this->sandbox->ensureToStringAllowed(        // line 38
($context["display_id"] ?? null), 38, $this->source)), 4 => ((        // line 39
($context["dom_id"] ?? null)) ? (("js-view-dom-id-" . $this->sandbox->ensureToStringAllowed(($context["dom_id"] ?? null), 39, $this->source))) : (""))];
        // line 42
        echo "  ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_prefix"] ?? null), 42, $this->source), "html", null, true);
        echo "
  ";
        // line 43
        if (($context["title"] ?? null)) {
            // line 44
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 44, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 46
        echo "  ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_suffix"] ?? null), 46, $this->source), "html", null, true);
        echo "
  ";
        // line 47
        if (($context["header"] ?? null)) {
            // line 48
            echo "    <div class=\"view-header\">
      ";
            // line 49
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["header"] ?? null), 49, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 52
        echo "  ";
        if (($context["exposed"] ?? null)) {
            // line 53
            echo "      ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["exposed"] ?? null), 53, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 55
        echo "  ";
        if (($context["attachment_before"] ?? null)) {
            // line 56
            echo "    <div class=\"attachment attachment-before\">
      ";
            // line 57
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attachment_before"] ?? null), 57, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 60
        echo "
  ";
        // line 61
        if (($context["rows"] ?? null)) {
            // line 62
            echo "      ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["rows"] ?? null), 62, $this->source), "html", null, true);
            echo "
  ";
        } elseif (        // line 63
($context["empty"] ?? null)) {
            // line 64
            echo "    <div class=\"view-empty\">
      ";
            // line 65
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["empty"] ?? null), 65, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 68
        echo "
  ";
        // line 69
        if (($context["pager"] ?? null)) {
            // line 70
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["pager"] ?? null), 70, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 72
        echo "  ";
        if (($context["attachment_after"] ?? null)) {
            // line 73
            echo "    <div class=\"attachment attachment-after\">
      ";
            // line 74
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attachment_after"] ?? null), 74, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 77
        echo "  ";
        if (($context["more"] ?? null)) {
            // line 78
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["more"] ?? null), 78, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 80
        echo "  ";
        if (($context["footer"] ?? null)) {
            // line 81
            echo "    <div class=\"view-footer\">
      ";
            // line 82
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["footer"] ?? null), 82, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 85
        echo "  ";
        if (($context["feed_icons"] ?? null)) {
            // line 86
            echo "    <div class=\"feed-icons\">
      ";
            // line 87
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["feed_icons"] ?? null), 87, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
    }

    public function getTemplateName()
    {
        return "themes/custom/bimboprov/templates/classy/views/views-view.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  166 => 87,  163 => 86,  160 => 85,  154 => 82,  151 => 81,  148 => 80,  142 => 78,  139 => 77,  133 => 74,  130 => 73,  127 => 72,  121 => 70,  119 => 69,  116 => 68,  110 => 65,  107 => 64,  105 => 63,  100 => 62,  98 => 61,  95 => 60,  89 => 57,  86 => 56,  83 => 55,  77 => 53,  74 => 52,  68 => 49,  65 => 48,  63 => 47,  58 => 46,  52 => 44,  50 => 43,  45 => 42,  43 => 39,  42 => 38,  41 => 37,  40 => 36,  39 => 34,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/bimboprov/templates/classy/views/views-view.html.twig", "/repo/repo/n9/themes/custom/bimboprov/templates/classy/views/views-view.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 34, "if" => 43);
        static $filters = array("clean_class" => 36, "escape" => 42);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['clean_class', 'escape'],
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
