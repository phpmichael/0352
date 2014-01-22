<?php
class Minify_html
{
    public function render()
    {
        $CI =& get_instance();
        $buffer = $CI->output->get_output();

        $buffer = $this->regex_minify($buffer);

        $CI->output->set_output($buffer);
        $CI->output->_display();
    }

    private function regex_minify($buffer)
    {
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s', // shorten multiple whitespace sequences
            '#(?://)?<!\[CDATA\[(.*?)(?://)?\]\]>#s' //leave CDATA alone
        );
        $replace = array(
            '>',
            '<',
            '\\1',
            "//&lt;![CDATA[\n".'\1'."\n//]]>"
        );

        return preg_replace($search, $replace, $buffer);
    }

    private function tidy_minify($buffer)
    {
        $options = array(
            'clean' => true,
            'hide-comments' => true,
            'indent' => true
        );

        $buffer = tidy_parse_string($buffer, $options, 'utf8');
        tidy_clean_repair($buffer);
        // warning: if you generate XML, HTML Tidy will break it (by adding some HTML: doctype, head, body..) if not configured properly

        return $buffer;
    }
}