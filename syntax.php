<?php
/**
 * Plugin Acronym: Allows to use the acronym tag in HTML
 *
 * Syntax: <acronym title="my explanation">
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Thorsten Staerk <dev@staerk.de>
 */
     
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
     
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_acronym extends DokuWiki_Syntax_Plugin 
{
     
    function getInfo()
    {
        return array
        (
            'author' => 'Thorsten Staerk',
            'email'  => 'dev@staerk.de',
            'date'   => '2011-06-30',
            'name'   => 'Acronym Plugin',
            'desc'   => 'allows you to use the acronym html tag',
            'url'    => 'http://www.staerk.de/thorsten/Acronym',
        );
    }
     
   /**
    * Get the type of syntax this plugin defines.
    *
    * @param none
    * @return String <tt>'substition'</tt> (i.e. 'substitution').
    * @public
    * @static
    */
    function getType()
    {
        return 'formatting';
    }
     
   /**
    * Where to sort in?
    *
    * @param none
    * @return Integer <tt>6</tt>.
    * @public
    * @static
    */
    function getSort()
    {
        return 1;
    }
     
     
   /**
    * Connect lookup pattern to lexer.
    *
    * @param $aMode String The desired rendermode.
    * @return none
    * @public
    * @see render()
    */
    function connectTo($mode) 
    {
        $this->Lexer->addEntryPattern('<acronym title=.*?>(?=.*?</acronym>)',$mode,'plugin_acronym');
    }
     
    function postConnect() 
    {
        $this->Lexer->addExitPattern('</acronym>','plugin_acronym');
    }
     
     
   /**
    * Handler to prepare matched data for the rendering process.
    *
    * <p>
    * The <tt>$aState</tt> parameter gives the type of pattern
    * which triggered the call to this method:
    * </p>
    * <dl>
    * <dt>DOKU_LEXER_ENTER</dt>
    * <dd>a pattern set by <tt>addEntryPattern()</tt></dd>
    * <dt>DOKU_LEXER_MATCHED</dt>
    * <dd>a pattern set by <tt>addPattern()</tt></dd>
    * <dt>DOKU_LEXER_EXIT</dt>
    * <dd> a pattern set by <tt>addExitPattern()</tt></dd>
    * <dt>DOKU_LEXER_SPECIAL</dt>
    * <dd>a pattern set by <tt>addSpecialPattern()</tt></dd>
    * <dt>DOKU_LEXER_UNMATCHED</dt>
    * <dd>ordinary text encountered within the plugin's syntax mode
    * which doesn't match any pattern.</dd>
    * </dl>
    * @param $aMatch String The text matched by the patterns.
    * @param $aState Integer The lexer state for the match.
    * @param $aPos Integer The character position of the matched text.
    * @param $aHandler Object Reference to the Doku_Handler object.
    * @return Integer The current lexer state for the match.
    * @public
    * @see render()
    * @static
    */
    function handle($match, $state, $pos, &$handler)
    {
        switch ($state) 
        {
            case DOKU_LEXER_ENTER : 
                return array($state, $match);
            case DOKU_LEXER_MATCHED :
                //break;
            case DOKU_LEXER_UNMATCHED :
                return array($state, $match);
            case DOKU_LEXER_EXIT :
                return array($state, '');
            case DOKU_LEXER_SPECIAL :
                //break;
        }
        return false;
    }
     
   /**
    * Handle the actual output creation.
    *
    * <p>
    * The method checks for the given <tt>$aFormat</tt> and returns
    * <tt>FALSE</tt> when a format isn't supported. <tt>$aRenderer</tt>
    * contains a reference to the renderer object which is currently
    * handling the rendering. The contents of <tt>$aData</tt> is the
    * return value of the <tt>handle()</tt> method.
    * </p>
    * @param $aFormat String The output format to generate.
    * @param $aRenderer Object A reference to the renderer object.
    * @param $aData Array The data created by the <tt>handle()</tt>
    * method.
    * @return Boolean <tt>TRUE</tt> if rendered successfully, or
    * <tt>FALSE</tt> otherwise.
    * @public
    * @see handle()
    */
    function render($mode, &$renderer, $data) 
    {
        if($mode == 'xhtml')
        {
            list($state,$match) = $data;
            $match=$data[1];
            switch ($state) 
            {
                case DOKU_LEXER_ENTER :
                    $renderer->doc .= "$match";
                case DOKU_LEXER_UNMATCHED :
                    $renderer->doc .= "$match";
                case DOKU_LEXER_EXIT :
                    $renderer->doc .= "";
            }
            return true;
        }
        return false;
    }
}
   
//Setup VIM: ex: et ts=4 enc=utf-8 :
?>

