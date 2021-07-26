<?php

defined( 'ABSPATH' ) or die;

class Language_Detector {
    protected $supported_langs;
    protected $user_lang;

    public function __construct() {
        $this->supported_langs = [
            'Español' => 'es', // Default (without slug)
            'English (UK)' => 'en', 
        ];
        $this->user_lang = $this->get_preferred_language();
    }

    public function detect_language() {
        $current_lang = $this->get_current_lang();
        $saved_lang = $_COOKIE['lang'] ?? null;
    
        if ($saved_lang) {
            if ($saved_lang != $current_lang) {
                $this->redirect_to_language($saved_lang);
            }
        } else {
            ?>
            <script>console.log('current_lang: <?= $current_lang ?>')</script>
            <script>console.log('saved_lang: <?= $saved_lang ?>')</script>
            <script>console.log('user_lang: <?= $this->user_lang ?>')</script>
            <?php
            if ($current_lang != $this->user_lang) {
                add_filter( 'body_class', array($this, 'show_language_switcher' ) );
            }
        }
    }

    function show_language_switcher( $classes ) {
        $classes[] = 'show-language-switcher';
        return $classes;
    }

    public function get_user_lang() {
        return $this->user_lang;
    }

    protected function get_preferred_language() {
        $accepted_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2);
        

        if ( !in_array($accepted_lang, array_values($this->supported_langs)) ) {
            if ( $accepted_lang === 'ca' ) {
                $accepted_lang = 'es'; // Catalan will be treated as spanish
            } else {
                $accepted_lang = 'en'; // Default language
            }
        }
        
        return $accepted_lang;
    }

    public function get_current_lang() {
        $current_lang = explode( '/', $_SERVER['REQUEST_URI'] )[1];
    
        if ( !in_array($current_lang, $this->supported_langs) ) {
            $current_lang = $this->supported_langs[array_key_first($this->supported_langs)];
        }
    
        return $current_lang;
    }

    protected function redirect_to_language( $lang ) {
        $default_lang = $this->supported_langs[array_key_first($this->supported_langs)];
        if ( $lang === $default_lang ) {
            $new_path = '/' . implode( '/', array_slice( explode('/', $_SERVER['REQUEST_URI']), 2 ));
        } else {
            $new_path = '/' . $lang . $_SERVER['REQUEST_URI'];
        }
        wp_redirect( $new_path );
        exit;
    }

    public function generate_switch_icon() {
        switch( $this->user_lang ) {
            case 'es': return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="25"><g fill="#c8414b"><path d="M0 385c0 22 17 39 38 39h436c21 0 38-17 38-39v-32H0v32zM474 88H38c-21 0-38 17-38 39v32h512v-32c0-22-17-39-38-39z"/></g><path fill="#ffd250" d="M0 159h512v194H0z"/><path d="M216 256l8-34c0-3-2-6-5-6h-5c-4 0-6 3-5 6l7 34z" fill="#c8414b"/><path fill="#f5f5f5" d="M207 238h18v75h-18z"/><path fill="#fab446" d="M203 230h27v8h-27z"/><g fill="#c8414b"><path d="M185 256h45v9h-45zM230 291l-27-9v-8l27 8zM84 256l7-34c1-3-1-6-5-6h-5c-3 0-5 3-5 6l8 34z"/></g><path d="M115 230c-5 0-9 3-9 8v58c0 10 10 31 44 31s44-21 44-31v-58c0-5-4-8-9-8h-70z" fill="#f5f5f5"/><g fill="#c8414b"><path d="M150 274h-44v-36c0-5 4-8 9-8h35v44zM150 274h44v22a22 22 0 01-44 0v-22z"/></g><path d="M106 274h44v22a22 22 0 01-44 0v-22z" fill="#fab446"/><g fill="#c8414b"><path d="M141 313v-39h-9v43c4 0 7-2 9-4zM124 317v-43h-9v39c2 2 5 4 9 4z"/></g><path fill="#ffb441" d="M115 256h26v9h-26z"/><g fill="#fab446"><path d="M115 238h26v9h-26z"/><path d="M119 244h18v16h-18z"/></g><path fill="#f5f5f5" d="M75 238h18v75H75z"/><g fill="#fab446"><path d="M71 309h26v9H71zM71 230h26v8H71z"/></g><path fill="#5064aa" d="M66 318h36v9H66z"/><path fill="#fab446" d="M207 309h27v9h-27z"/><path fill="#5064aa" d="M199 318h35v9h-35z"/><path fill="#fab446" d="M124 221h53v9h-53z"/><path fill="#ffb441" d="M146 194h9v27h-9z"/><g fill="#f5f5f5"><path d="M141 207a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 9 4 4 0 000-9z"/><path d="M159 207a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 9 4 4 0 000-9z"/><path d="M177 216a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 8 4 4 0 000-8zM124 216a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 8 4 4 0 000-8z"/></g><path d="M177 291v5a4 4 0 01-9 0v-5h9m8-9h-26v14a13 13 0 0026 0v-14z" fill="#fab446"/><path d="M172 265c-5 0-9-4-9-9v-9c0-5 4-9 9-9s9 4 9 9v9c0 5-4 9-9 9z" fill="#ffa0d2"/><circle cx="150.1" cy="273.6" r="13.2" fill="#5064aa"/><path fill="#fab446" d="M146 177h9v26h-9z"/><path d="M124 221l-9-9 5-5c8-8 19-13 30-13s22 5 30 13l5 5-8 9h-53z" fill="#c8414b"/><g fill="#ffd250"><circle cx="150.1" cy="211.9" r="4.4"/><circle cx="132.4" cy="211.9" r="4.4"/><circle cx="167.7" cy="211.9" r="4.4"/></g><g fill="#c8414b"><path d="M71 256h44v9H71zM71 291l26-9v-8l-26 8z"/></g></svg>';
            case 'en': return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" width="30" height="15"><clipPath id="a"><path d="M0 0v30h60V0z"/></clipPath><clipPath id="b"><path d="M30 15h30v15zv15H0zH0V0zV0h30z"/></clipPath><g clip-path="url(#a)"><path d="M0 0v30h60V0z" fill="#012169"/><path d="M0 0l60 30m0-30L0 30" stroke="#fff" stroke-width="6"/><path d="M0 0l60 30m0-30L0 30" clip-path="url(#b)" stroke="#C8102E" stroke-width="4"/><path d="M30 0v30M0 15h60" stroke="#fff" stroke-width="10"/><path d="M30 0v30M0 15h60" stroke="#C8102E" stroke-width="6"/></g></svg>';
        }
    }
    
    public function generate_switch_msg() {
        switch( $this->user_lang ) {
            case 'es': return 'Quieres ir a la página web en español?';
            case 'en': return 'Do you want to switch to the English website?';
        }
    }

    public function generate_language_switcher() {
        ?>

        <aside id="language-switcher">
            <div class="grid-container">
                <i><?= $this->generate_switch_icon() ?></i>
                <span><?= $this->generate_switch_msg() ?></span>
                <svg id="switch-language" data-lang="<?= $this->get_user_lang() ?>" fill="#00b100" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M0 12.116l2.053-1.897c2.401 1.162 3.924 2.045 6.622 3.969 5.073-5.757 8.426-8.678 14.657-12.555l.668 1.536c-5.139 4.484-8.902 9.479-14.321 19.198-3.343-3.936-5.574-6.446-9.679-10.251z"></path></svg>
                <svg id="close-language-switcher" data-lang="<?= $this->get_current_lang() ?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="20" height="20"><path fill="#f15b6c" d="M82 25.275L74.726 18.001 50 42.727 25.276 17.996 18.003 25.268 42.727 50 18 74.727 25.274 82.001 50 57.275 74.722 82.003 81.996 74.732 57.273 50.002z"></path><path fill="#1f212b" d="M74.722,83.003L74.722,83.003c-0.265,0-0.52-0.105-0.707-0.293L50,58.689l-24.02,24.019c-0.391,0.391-1.023,0.391-1.414,0l-7.274-7.274c-0.391-0.391-0.391-1.023,0-1.414L41.313,50L17.296,25.975c-0.391-0.391-0.391-1.024,0-1.414l7.273-7.271c0.188-0.188,0.442-0.293,0.707-0.293l0,0c0.265,0,0.52,0.105,0.707,0.293L50,41.312l24.019-24.019c0.391-0.391,1.023-0.391,1.414,0l7.274,7.274c0.391,0.391,0.391,1.023,0,1.414l-24.02,24.02l24.016,24.023c0.391,0.391,0.391,1.024,0,1.414l-7.273,7.271C75.242,82.898,74.987,83.003,74.722,83.003z M50,56.275L50,56.275c0.265,0,0.52,0.105,0.707,0.293l24.015,24.021l5.859-5.857L56.566,50.709c-0.391-0.391-0.391-1.023,0-1.414l24.02-24.02l-5.86-5.86L50.707,43.434c-0.188,0.188-0.442,0.293-0.707,0.293l0,0c-0.265,0-0.52-0.105-0.707-0.293L25.276,19.411l-5.859,5.857l24.018,24.024c0.391,0.391,0.391,1.023,0,1.414L19.414,74.727l5.86,5.86l24.02-24.019C49.481,56.38,49.735,56.275,50,56.275z"></path><path fill="#1f212b" d="M74.5 75c-.128 0-.256-.049-.354-.146l-1-1c-.195-.195-.195-.512 0-.707s.512-.195.707 0l1 1c.195.195.195.512 0 .707C74.756 74.951 74.628 75 74.5 75zM71.5 72c-.128 0-.256-.049-.354-.146l-2-2c-.195-.195-.195-.512 0-.707s.512-.195.707 0l2 2c.195.195.195.512 0 .707C71.756 71.951 71.628 72 71.5 72zM67.5 68c-.128 0-.256-.049-.354-.146l-17.5-17.5c-.195-.195-.195-.512 0-.707l21.5-21.5c.195-.195.512-.195.707 0s.195.512 0 .707L50.707 50l17.146 17.146c.195.195.195.512 0 .707C67.756 67.951 67.628 68 67.5 68zM73.5 27c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707l1-1c.195-.195.512-.195.707 0s.195.512 0 .707l-1 1C73.756 26.951 73.628 27 73.5 27zM26.5 27c-.128 0-.256-.049-.354-.146l-1-1c-.195-.195-.195-.512 0-.707s.512-.195.707 0l1 1c.195.195.195.512 0 .707C26.756 26.951 26.628 27 26.5 27zM30.5 31c-.128 0-.256-.049-.354-.146l-2-2c-.195-.195-.195-.512 0-.707s.512-.195.707 0l2 2c.195.195.195.512 0 .707C30.756 30.951 30.628 31 30.5 31z"></path><path fill="#1f212b" d="M28.5 72c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707L49.293 50 32.146 32.854c-.195-.195-.195-.512 0-.707s.512-.195.707 0l17.5 17.5c.195.195.195.512 0 .707l-21.5 21.5C28.756 71.951 28.628 72 28.5 72zM25.5 75c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707l1-1c.195-.195.512-.195.707 0s.195.512 0 .707l-1 1C25.756 74.951 25.628 75 25.5 75z"></path></svg>
            </div>
        </aside>

        <?php
    }
}
