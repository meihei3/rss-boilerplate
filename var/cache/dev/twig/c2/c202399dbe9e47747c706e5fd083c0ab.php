<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* rss.xml.twig */
class __TwigTemplate_a718b6560b5a43fce88c741d9f66a9fc extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">
    <channel>
        <title><![CDATA[";
        // line 4
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "title", [], "any", false, false, false, 4), "html", null, true);
        yield "]]></title>
        <description><![CDATA[";
        // line 5
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "description", [], "any", false, false, false, 5), "html", null, true);
        yield "]]></description>
        <link>";
        // line 6
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "link", [], "any", false, false, false, 6), "html", null, true);
        yield "</link>
        <atom:link href=\"";
        // line 7
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "link", [], "any", false, false, false, 7), "html", null, true);
        yield "\" rel=\"self\" type=\"application/rss+xml\"/>
        <language>";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "language", [], "any", false, false, false, 8), "html", null, true);
        yield "</language>
        <lastBuildDate>";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "lastBuildDate", [], "any", false, false, false, 9), "format", ["D, d M Y H:i:s O"], "method", false, false, false, 9), "html", null, true);
        yield "</lastBuildDate>
        <generator>RSS Feed Generator Boilerplate</generator>
        ";
        // line 11
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "imageUrl", [], "any", false, false, false, 11)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 12
            yield "        <image>
            <url>";
            // line 13
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "imageUrl", [], "any", false, false, false, 13), "html", null, true);
            yield "</url>
            <title><![CDATA[";
            // line 14
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "title", [], "any", false, false, false, 14), "html", null, true);
            yield "]]></title>
            <link>";
            // line 15
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "link", [], "any", false, false, false, 15), "html", null, true);
            yield "</link>
        </image>
        ";
        }
        // line 18
        yield "        ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["feed"] ?? null), "items", [], "any", false, false, false, 18));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 19
            yield "        <item>
            <title><![CDATA[";
            // line 20
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, false, 20), "html", null, true);
            yield "]]></title>
            <description><![CDATA[";
            // line 21
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "description", [], "any", false, false, false, 21), "html", null, true);
            yield "]]></description>
            <link>";
            // line 22
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, false, 22), "html", null, true);
            yield "</link>
            <guid isPermaLink=\"";
            // line 23
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, false, 23) == CoreExtension::getAttribute($this->env, $this->source, $context["item"], "guid", [], "any", false, false, false, 23))) ? ("true") : ("false"));
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "guid", [], "any", false, false, false, 23), "html", null, true);
            yield "</guid>
            <pubDate>";
            // line 24
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "pubDate", [], "any", false, false, false, 24), "format", ["D, d M Y H:i:s O"], "method", false, false, false, 24), "html", null, true);
            yield "</pubDate>
            ";
            // line 25
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["item"], "category", [], "any", false, false, false, 25)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 26
                yield "            <category><![CDATA[";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "category", [], "any", false, false, false, 26), "html", null, true);
                yield "]]></category>
            ";
            }
            // line 28
            yield "            ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["item"], "author", [], "any", false, false, false, 28)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 29
                yield "            <author><![CDATA[";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "author", [], "any", false, false, false, 29), "html", null, true);
                yield "]]></author>
            ";
            }
            // line 31
            yield "        </item>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        yield "    </channel>
</rss>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "rss.xml.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  145 => 33,  138 => 31,  132 => 29,  129 => 28,  123 => 26,  121 => 25,  117 => 24,  111 => 23,  107 => 22,  103 => 21,  99 => 20,  96 => 19,  91 => 18,  85 => 15,  81 => 14,  77 => 13,  74 => 12,  72 => 11,  67 => 9,  63 => 8,  59 => 7,  55 => 6,  51 => 5,  47 => 4,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "rss.xml.twig", "/app/templates/rss.xml.twig");
    }
}
