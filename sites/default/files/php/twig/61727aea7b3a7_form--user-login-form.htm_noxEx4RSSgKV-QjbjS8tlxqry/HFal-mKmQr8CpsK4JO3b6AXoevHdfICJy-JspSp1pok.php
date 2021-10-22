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

/* themes/custom/bimboprov/templates/classy/form/form--user-login-form.html.twig */
class __TwigTemplate_fff1391f76f8d621f4ef45d99be6868ce3be70f07a1ddcf07d53fc086d280813 extends \Twig\Template
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
        echo "  <form";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 1, $this->source), "html", null, true);
        echo ">
    <fieldset class=\"c-form__fieldset\">
      ";
        // line 3
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["element"] ?? null), "messages", [], "any", false, false, true, 3), 3, $this->source), "html", null, true);
        echo "
      <ul class=\"form-list full\">
        <li>
          <span class=\"currentInput\">";
        // line 6
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["element"] ?? null), "name", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
        echo "<label class=\"currentInput-label\">E-mail</label></span>
        </li>
        <li>
          <div class=\"icon-contrasena js-contrasena\">
            <span class=\"currentInput listo\">";
        // line 10
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["element"] ?? null), "pass", [], "any", false, false, true, 10), 10, $this->source), "html", null, true);
        echo "<label class=\"currentInput-label\">";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Contraseña"));
        echo "</label></span><span class=\"icon ver js-mostrar-pass\"></span>
          </div>
        </li>
        <li class=\"c-form__terminos-aviso group-input required\">
          <label class=\"lbCh\">
            ";
        // line 15
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["element"] ?? null), "find_us", [], "any", false, false, true, 15), 15, $this->source), "html", null, true);
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("He leído y acepto"));
        echo " <a href=\"./terminos-y-condiciones\" title=\"";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Términos y Condiciones"));
        echo "\">";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Términos y Condiciones"));
        echo "</a>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("y el"));
        echo "<a href=\"#!\" title=\"";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Términos y Condiciones"));
        echo "\">";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Términos y Condiciones"));
        echo ".</a>
            <span class=\"flCh\"></span>
          </label>
        </li>
        <li>
          ";
        // line 20
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["element"] ?? null), "form_build_id", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
        echo "
          ";
        // line 21
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["element"] ?? null), "form_id", [], "any", false, false, true, 21), 21, $this->source), "html", null, true);
        echo "
          <div class=\"c-form__recaptcha--iniciar-sesion\">            
            ";
        // line 23
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["element"] ?? null), "actions", [], "any", false, false, true, 23), "submit", [], "any", false, false, true, 23), 23, $this->source), "html", null, true);
        echo "
          </div>
        </li>
      </ul>
    </fieldset>
  </form>";
    }

    public function getTemplateName()
    {
        return "themes/custom/bimboprov/templates/classy/form/form--user-login-form.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 23,  91 => 21,  87 => 20,  68 => 15,  58 => 10,  51 => 6,  45 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/bimboprov/templates/classy/form/form--user-login-form.html.twig", "/repo/repo/n9/themes/custom/bimboprov/templates/classy/form/form--user-login-form.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 1, "t" => 10);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape', 't'],
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
