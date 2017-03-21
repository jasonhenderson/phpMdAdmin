<?php
/**
 * This file is part of phpMdAdmin.
 *
 *  phpMdAdmin is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  phpMdAdmin is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package phpMdAdmin
 */


abstract class ErrorLevel
{
    const Info = "i";
    const Warning = "w";
    const Error = "e";
    const Success = "s";
}



// defacto enum
abstract class DocType
{
    const Readme = "readme";
    const Page = "page";
    const Slides = "slides";
}


abstract class FileExt
{
    const Markdown = "md";
    const Slides = "mds";
    const Pdf = "pdf";
    const Text = "txt";
}


abstract class CodeExt
{
    const JavaScript = "js";
    const HTML = "html";
    const CSS = "css";
    const SQL = "sql";
    const PHP = "php";
}
