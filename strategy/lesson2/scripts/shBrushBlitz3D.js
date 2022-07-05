/**
 * SyntaxHighlighter
 * http://alexgorbatchev.com/
 *
 * SyntaxHighlighter is donationware. If you are using it, please donate.
 * http://alexgorbatchev.com/wiki/SyntaxHighlighter:Donate
 *
 * @version
 * 2.0.320 (May 03 2009)
 * 
 * @copyright
 * Copyright (C) 2004-2009 Alex Gorbatchev.
 *
 * @license
 * This file is part of SyntaxHighlighter.
 * 
 * SyntaxHighlighter is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SyntaxHighlighter is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SyntaxHighlighter.  If not, see <http://www.gnu.org/copyleft/lesser.html>.
 */
SyntaxHighlighter.brushes.B3D = function()
{
  // Created by Peter Atoria @ http://iAtoria.com
  
  var keywords =  'While while not RenderWorld wend Wend UpdateWorld Flip';
  
  this.regexList = [
    { regex: /;.*$/gm,                    css: 'comments' },      // one line comments
    { regex: SyntaxHighlighter.regexLib.singleLineCComments,  css: 'comments' },    // one line comments
    { regex: SyntaxHighlighter.regexLib.multiLineCComments,   css: 'comments' },    // multiline comments
    { regex: SyntaxHighlighter.regexLib.doubleQuotedString,   css: 'string' },    // double quoted strings
    { regex: SyntaxHighlighter.regexLib.singleQuotedString,   css: 'string' },    // single quoted strings
    { regex: /\b([\d]+(\.[\d]+)?|0x[a-f0-9]+)\b/gi,       css: 'b3dvalue' },     // numbers
    { regex: new RegExp(this.getKeywords(keywords), 'gm'),    css: 'keyword' }   // keywords
    ];
  
  this.forHtmlScript(SyntaxHighlighter.regexLib.scriptScriptTags);
};

SyntaxHighlighter.brushes.B3D.prototype = new SyntaxHighlighter.Highlighter();
SyntaxHighlighter.brushes.B3D.aliases = ['blitz3d', 'b3d'];
