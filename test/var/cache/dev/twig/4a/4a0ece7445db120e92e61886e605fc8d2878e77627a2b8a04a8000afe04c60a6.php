<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @PrestaShop/Admin/Sell/Catalog/Categories/Blocks/menu_thumbnail_images.html.twig */
class __TwigTemplate_672d8ded9b89d056c7c7f3b37c76c0b56972ea5a3beb70bd545fe91e9087972f extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'category_menu_thumbnails' => [$this, 'block_category_menu_thumbnails'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@PrestaShop/Admin/Sell/Catalog/Categories/Blocks/menu_thumbnail_images.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@PrestaShop/Admin/Sell/Catalog/Categories/Blocks/menu_thumbnail_images.html.twig"));

        // line 25
        echo "
";
        // line 26
        $this->displayBlock('category_menu_thumbnails', $context, $blocks);
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function block_category_menu_thumbnails($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "category_menu_thumbnails"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "category_menu_thumbnails"));

        // line 27
        echo "  ";
        if (((isset($context["menuThumbnailImages"]) || array_key_exists("menuThumbnailImages", $context)) &&  !twig_test_empty(($context["menuThumbnailImages"] ?? $this->getContext($context, "menuThumbnailImages"))))) {
            // line 28
            echo "    <div>
      ";
            // line 29
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["menuThumbnailImages"] ?? $this->getContext($context, "menuThumbnailImages")));
            foreach ($context['_seq'] as $context["_key"] => $context["menuThumbnail"]) {
                // line 30
                echo "        <figure class=\"figure\">
          <img src=\"";
                // line 31
                echo twig_escape_filter($this->env, $this->getAttribute($context["menuThumbnail"], "path", []), "html", null, true);
                echo "\" class=\"figure-img img-fluid img-thumbnail\">
          <figcaption class=\"figure-caption\">
            <button class=\"btn btn-outline-danger btn-sm js-form-submit-btn\"
                    data-form-submit-url=\"";
                // line 34
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_categories_delete_menu_thumbnail", ["categoryId" => $this->getAttribute($this->getAttribute(($context["editableCategory"] ?? $this->getContext($context, "editableCategory")), "id", []), "value", []), "menuThumbnailId" => $this->getAttribute($context["menuThumbnail"], "id", [])]), "html", null, true);
                echo "\"
                    data-form-csrf-token=\"";
                // line 35
                echo twig_escape_filter($this->env, $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken("delete-menu-thumbnail"), "html", null, true);
                echo "\"
            >
              <i class=\"material-icons\">
                delete_forever
              </i>
              ";
                // line 40
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Delete", [], "Admin.Actions"), "html", null, true);
                echo "
            </button>
          </figcaption>
        </figure>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['menuThumbnail'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 45
            echo "    </div>
  ";
        }
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Sell/Catalog/Categories/Blocks/menu_thumbnail_images.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  100 => 45,  89 => 40,  81 => 35,  77 => 34,  71 => 31,  68 => 30,  64 => 29,  61 => 28,  58 => 27,  40 => 26,  37 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{#**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *#}

{% block category_menu_thumbnails %}
  {% if menuThumbnailImages is defined and menuThumbnailImages is not empty %}
    <div>
      {% for menuThumbnail in menuThumbnailImages %}
        <figure class=\"figure\">
          <img src=\"{{ menuThumbnail.path }}\" class=\"figure-img img-fluid img-thumbnail\">
          <figcaption class=\"figure-caption\">
            <button class=\"btn btn-outline-danger btn-sm js-form-submit-btn\"
                    data-form-submit-url=\"{{ path('admin_categories_delete_menu_thumbnail', {'categoryId': editableCategory.id.value, 'menuThumbnailId': menuThumbnail.id}) }}\"
                    data-form-csrf-token=\"{{ csrf_token('delete-menu-thumbnail') }}\"
            >
              <i class=\"material-icons\">
                delete_forever
              </i>
              {{ 'Delete'|trans({}, 'Admin.Actions') }}
            </button>
          </figcaption>
        </figure>
      {% endfor %}
    </div>
  {% endif %}
{% endblock %}
", "@PrestaShop/Admin/Sell/Catalog/Categories/Blocks/menu_thumbnail_images.html.twig", "/var/www/html/src/PrestaShopBundle/Resources/views/Admin/Sell/Catalog/Categories/Blocks/menu_thumbnail_images.html.twig");
    }
}
