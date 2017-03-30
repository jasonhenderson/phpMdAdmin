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


require_once CONTROLLERS_PATH . '/FileControllerBase.php';

//use cebe;
use Dompdf\Dompdf;
//use JonnyW\PhantomJs\Client;

class ViewController extends FileControllerBase {

    /**
     *
     *
     * @param string  $group
     * @param string  $file
     */
    public function md($group, $file)
    {
        if (empty($group)) {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "Group is required to view the markdown";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/";
        }
        elseif (empty($file)) {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "File is required to view the markdown";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/files/" . $group;
        }
        else {
            $this->pageTitle = 'md page viewer';
            $this->view = '/view/md.php';
            $this->master = '/plain.php';

            $text = Config::storage($group)->text($file);
            $dataPath = Config::storage()->dataRelDir;
            $processedText = str_replace("{PATH}", BASE_PATH . "/" . $dataPath . "/" . $group . "/", $text);

            $parser = new \cebe\markdown\GithubMarkdown();
            $parser->html5 = true;

            $this->html = $parser->parse($processedText);
        }

        $this->render();
    }


    /**
     *
     *
     * @param string  $group
     * @param string  $file
     */
    public function slides($group, $file)
    {
        if (empty($group)) {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "Group is required to view the markdown";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/";
        }
        elseif (empty($file)) {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "File is required to view the markdown";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/files/" . $group;
        }
        else {

            $this->pageTitle = 'md slide viewer';
            $this->view = '/view/slides.php';
            $this->master = '/plain.php';

            // Get the text from the file
            $text = Config::storage($group)->text($file);
            $dataPath = Config::storage()->dataRelDir;

            // Replace the image base URLs

            $this->markdown = str_replace("{PATH}", BASE_PATH . "/" . $dataPath . "/" . $group . "/", $text);
        }

        $this->render();
    }


    /**
     *
     *
     * @param string  $group
     * @param string  $file
     */
    public function text($group, $file)
    {
        if (empty($group)) {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "Group is required to view the markdown";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/";
        }
        elseif (empty($file)) {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "File is required to view the markdown";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/files/" . $group;
        }
        else {
            $this->pageTitle = 'md slide viewer';
            $this->view = '/view/slides.php';
            $this->master = '/plain.php';

            // Get the text from the file
            $this->text = Config::storage($group)->text($file);
        }

        $this->render();
    }


    /**
     *
     *
     * @param string  $type
     * @param string  $group
     * @param string  $file
     */
    public function pdf($type, $group, $file)
    {
        if (empty($type)) {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "Type of PDF to create is required to create the PDF";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/";
            $this->render();
        }
        else if (empty($group)) {
                $this->view = '/admin/error.php';
                $this->master = '/threePanel.php';
                $this->message = "Group is required to create the PDF";
                $this->level = ErrorLevel::Error;
                $this->redirect = BASE_PATH . "/";
                $this->render();
            }
        elseif (empty($file)) {
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "File is required to create the PDF";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/files/" . $group;
            $this->render();
        }
        else {
            $this->printWithDomPdf($type, $group, $file);
            //$this->printWithPhantomJS($type, $group, $file);
        }
    }


    /**
     *
     *
     * @param string  $endpoint (optional)
     * @return
     */
    private function siteURL($endpoint = "")
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        $url = $protocol . $domainName . $endpoint;
        return $url;
    }


    /**
     *
     *
     * @param string  $type
     * @param string  $group
     * @param string  $file
     * @return
     */
    private function printWithDomPdf($type, $group, $file)
    {
        // Build the given page URL
        $url = $this->siteURL(BASE_PATH . "/view/$type/$group/$file");

        // Get the HTML through the server using CURL...
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $cookie_data =
                implode(
                "; ",
                array_map(


                    /**
                     *
                     */
                    function($k, $v)
                    {
                        return "$k=$v";
                    },
                    array_keys($_COOKIE),
                    array_values($_COOKIE)
                )
            );
            curl_setopt($ch, CURLOPT_COOKIE, $cookie_data);

            $curlResult = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close ($curl);

            if ($httpCode != 200) {
                $this->view = '/admin/error.php';
                $this->master = '/threePanel.php';
                $this->message = "Could not read the file to create the PDF";
                $this->level = ErrorLevel::Error;
                $this->redirect = BASE_PATH . "/files/" . $group;
                $this->render();
            }
            else {
                $this->pageTitle = 'md pdf viewer';
                $this->master = '/empty.php';
                // instantiate and use the dompdf class
                $dompdf = new Dompdf();

                // Make sure latest HTML is supported
                $dompdf->set_option('isHtml5ParserEnabled', true);

                // Parse the HTML
                $dompdf->loadHtml($curlResult);

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('letter', 'landscape');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser
                $dompdf->stream();
            }
        }
        else {
            // Could not initialize cURL
            $this->view = '/admin/error.php';
            $this->master = '/threePanel.php';
            $this->message = "Could not read the file to create the PDF";
            $this->level = ErrorLevel::Error;
            $this->redirect = BASE_PATH . "/files/" . $group;
            $this->render();
        }
    }


    /**
     *
     *
     * @param string  $type
     * @param string  $group
     * @param string  $file
     */
    private function printWithPhantomJS($type, $group, $file)
    {
        $url = $this->siteURL(BASE_PATH . "/view/$type/$group/$file");

        // TODO: change this to go in files sub-directory
        $filePath = Config::storage($group)->groupPath() . "/files/$file.pdf";

        $client = Client::getInstance();
        $client->getEngine()->addOption('--load-images=true');
        $client->getEngine()->setPath(ROOT_PATH . '/bin/phantomjs');

        /**
         *
         *
         * @see JonnyW\PhantomJs\Http\PdfRequest
         * */
        $request = $client->getMessageFactory()->createPdfRequest($url, 'GET');
        $request->setOutputFile($filePath);
        $request->setFormat('Letter');
        $request->setOrientation('landscape');
        $request->setMargin('2.54cm');



        /**
         *
         *
         * @see JonnyW\PhantomJs\Http\Response
         * */
        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);

        $this->view = '/api/redirect.php';
        $this->master = '/empty.php';
        $this->message = "File is required to create the PDF";
        $this->level = ErrorLevel::Error;
        $this->redirect = BASE_PATH . "/files/" . $group;
        $this->render();
    }


}
