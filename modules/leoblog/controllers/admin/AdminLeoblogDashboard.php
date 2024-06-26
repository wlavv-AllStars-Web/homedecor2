<?php
/**
 * 2007-2015 Leotheme
 *
 * NOTICE OF LICENSE
 *
 *  Content Management
 *
 * DISCLAIMER
 *
 *  @author    leotheme <leotheme@gmail.com>
 *  @copyright 2007-2015 Leotheme
 *  @license   http://leotheme.com - prestashop template provider
 */

include_once(_PS_MODULE_DIR_.'leoblog/loader.php');
require_once(_PS_MODULE_DIR_.'leoblog/classes/comment.php');

class AdminLeoblogDashboardController extends ModuleAdminController
{

    public function __construct()
    {
        $this->bootstrap = true;
        $this->display = 'view';
        $this->addRowAction('view');
        parent::__construct();
    }

    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();
        
        $this->page_header_toolbar_title = $this->l('Dashboard');
        $this->page_header_toolbar_btn = array();
    }
    
    public function postProcess()
    {
        if (count($this->errors)) {
            return false;
        }
            
        if (Tools::isSubmit('saveConfiguration')) {
            $keys = LeoBlogHelper::getConfigKey(false);
            $post = array();
            foreach ($keys as $key) {
                # validate module
                $post[$key] = Tools::getValue($key);
                if ($key == 'social_code') {
                    $post[$key] = LeoBlogHelper::correctEnCodeData(Tools::getValue($key));
                }
            }

            $multi_lang_keys = LeoBlogHelper::getConfigKey(true);
            foreach ($multi_lang_keys as $multi_lang_key) {
                foreach (Language::getIDs(false) as $id_lang) {
                    $post[$multi_lang_key.'_'.(int)$id_lang] = Tools::getValue($multi_lang_key.'_'.(int)$id_lang);
                }
            }
            // print_r(json_encode($post));die;
            // Configuration::updateValue(Tools::strtoupper(_LEO_BLOG_PREFIX_.'cfg_global_'.$post['template']), json_encode($post));
            if ($post['template'] != 'default') {
                LeoBlogConfig::updateConfigValue('cfg_global_'.$post['template'], json_encode($post));
            } else {
                LeoBlogConfig::updateConfigValue('cfg_global', json_encode($post));
            }
            

            Configuration::updateValue(Tools::strtoupper(_LEO_BLOG_PREFIX_.'template_current'), $post['template']);
            Configuration::updateValue('LEOBLOG_DASHBOARD_DEFAULTTAB', Tools::getValue('LEOBLOG_DASHBOARD_DEFAULTTAB'));
        }
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        $this->addJqueryUi('ui.widget');
        $this->addJqueryPlugin('tagify');
        if (file_exists(_PS_THEME_DIR_.'js/modules/leoblog/assets/form.js')) {
            $this->context->controller->addJS(__PS_BASE_URI__.'modules/leoblog/assets/admin/form.js');
        } else {
            $this->context->controller->addJS(__PS_BASE_URI__.$this->module->getMediaDir().'js/admin/form.js');
        }
    }

    public function renderView()
    {
        $link = $this->context->link;

        $quicktools = array();

        $quicktools[] = array(
            'title' => $this->l('Categories'),
            'href' => $link->getAdminLink('AdminLeoblogCategories'),
            'icon' => 'icon-desktop',
            'class' => '',
        );

        $quicktools[] = array(
            'title' => $this->l('Add Category'),
            'href' => $link->getAdminLink('AdminLeoblogCategories'),
            'icon' => 'icon-list',
            'class' => '',
        );

        $quicktools[] = array(
            'title' => $this->l('Blogs'),
            'href' => $link->getAdminLink('AdminLeoblogBlogs'),
            'icon' => 'icon-list',
            'class' => '',
        );

        $quicktools[] = array(
            'title' => $this->l('Add Blog'),
            'href' => $link->getAdminLink('AdminLeoblogBlogs').'&addleoblog_blog',
            'icon' => 'icon-list',
            'class' => '',
        );

        $quicktools[] = array(
            'title' => $this->l('Comments'),
            'href' => $link->getAdminLink('AdminLeoblogComments'),
            'icon' => 'icon-list',
            'class' => '',
        );

        $onoff = array(
            array(
                'id' => 'indexation_on',
                'value' => 1,
                'label' => $this->l('Enabled')
            ),
            array(
                'id' => 'indexation_off',
                'value' => 0,
                'label' => $this->l('Disabled')
            )
        );

        //$obj           = new Leoblogcat();
        //$menus         = $obj->getDropdown(null, $obj->id_parent);
        $templates = LeoBlogHelper::getTemplates();
        $url_rss = Tools::htmlentitiesutf8('http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__).'modules/leoblog/rss.php';
        $form = '';

        $this->fields_form[0]['form'] = array(
            'tinymce' => true,
            // 'legend' => array(
                // 'title' => $this->l('General Setting'),
                // 'icon' => 'icon-folder-close',
            // ),
            'input' => array(
                
                // custom template
                array(
                    'type' => 'hidden',
                    'name' => 'LEOBLOG_DASHBOARD_DEFAULTTAB',
                    'default' => '',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Theme - Template'),
                    'name' => 'template',
                    'options' => array('query' => $templates,
                        'id' => 'template',
                        'name' => 'template'),
                    'default' => 'default',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Root Link Title'),
                    'name' => 'blog_link_title',
                    'required' => true,
                    'lang' => true,
                    'desc' => $this->l('Make Link Title For Blog Root Link, Example http://domain/blog'),
                    'default' => 'Blog',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Friendly URL'),
                    'name' => 'url_use_id',
                    'required' => false,
                    'class' => 'form-action',
                    'is_bool' => true,
                    'default' => '1',
                    'hint' => $this->l('When turn on Prestashop SEO, Blog show Friendly URL'),
                    'options' => array(
                        'query' => array(
                            array(
                                'value' => 1,
                                'name' => self::l('Include ID'),
                            ),
                            array(
                                'value' => 0,
                                'name' => self::l('NOT include ID'),
                            ),
                        ),
                        'id' => 'value',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Root'),
                    'name' => 'link_rewrite',
                    'required' => true,
                    'lang' => true,
//                    'desc' => $this->l('Make seo start with this, Example http://domain/blog'),
                    'hint' => $this->l('Example http://domain/blog.html'),
                    'default' => 'blog',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Category'),
                    'name' => 'category_rewrite',
                    'required' => true,
                    'lang' => true,
                    'default' => 'category',
                    'form_group_class' => 'url_use_id_sub url_use_id-0',
                    'hint' => $this->l('Example http://domain/blog/category/name.html'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Detail'),
                    'name' => 'detail_rewrite',
                    'required' => true,
                    'lang' => true,
                    'default' => 'detail',
                    'form_group_class' => 'url_use_id_sub url_use_id-0',
                    'hint' => $this->l('Example http://domain/blog/detail/name.html'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Meta Title'),
                    'name' => 'meta_title',
                    'lang' => true,
                    'cols' => 40,
                    'rows' => 10,
                    'default' => 'Blog',
                    'desc' => $this->l('Display browser title on frontpage blog')
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Meta description'),
                    'name' => 'meta_description',
                    'lang' => true,
                    'cols' => 40,
                    'rows' => 10,
                    'default' => '',
                    'desk' => $this->l('Display meta descrition on frontpage blog').'note: note &lt;&gt;;=#{}'
                ),
                array(
                    'type' => 'tags',
                    'label' => $this->l('Meta keywords'),
                    'name' => 'meta_keywords',
                    'default' => '',
                    'lang' => true,
                    'desc' => array(
                        $this->l('Invalid characters:').' &lt;&gt;;=#{}',
                        $this->l('To add "tags" click in the field, write something, and then press "Enter."')
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable Rss:'),
                    'name' => 'indexation',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '',
                    'values' => $onoff,
                    'desc' => $url_rss
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Rss Limit Items'),
                    'name' => 'rss_limit_item',
                    'default' => '20',
                    'desc' => 'Set Maximun shows in rss'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Rss Title'),
                    'name' => 'rss_title_item',
                    'default' => 'RSS FEED',
                    'desc' => 'Set title in rss'
                ),
//                array(
//                    'type' => 'text',
//                    'label' => $this->l('Limit Latest Item'),
//                    'name' => 'latest_limit_items',
//                    'default' => '20',
//                    'desc' => 'Set Maximun shows in latest blog page'
//                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-danger'
            )
        );

        $this->fields_form[1]['form'] = array(
            'tinymce' => true,
            'default' => '',
            // 'legend' => array(
                // 'title' => $this->l('Listing Blog Setting'),
                // 'icon' => 'icon-folder-close'
            // ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Category Info:'),
                    'name' => 'listing_show_categoryinfo',
                    'required' => false,
                    'class' => 't',
                    'desc' => $this->l('Display category information in listing blogs'),
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Sub Categories:'),
                    'name' => 'listing_show_subcategories',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                    'desc' => $this->l('Display subcategory in listing blog')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Leading Column:'),
                    'name' => 'listing_leading_column',
                    'required' => false,
                    'class' => 't',
                    'default' => '1',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Leading Limit Items:'),
                    'name' => 'listing_leading_limit_items',
                    'required' => false,
                    'class' => 't',
                    'default' => '2',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Leading Image Width:'),
                    'name' => 'listing_leading_img_width',
                    'required' => false,
                    'class' => 't',
                    'default' => '690',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Leading Image Height:'),
                    'name' => 'listing_leading_img_height',
                    'required' => false,
                    'class' => 't',
                    'default' => '300',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Secondary Column:'),
                    'name' => 'listing_secondary_column',
                    'required' => false,
                    'class' => 't',
                    'default' => '3',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Secondary Limit Items:'),
                    'name' => 'listing_secondary_limit_items',
                    'required' => false,
                    'class' => 't',
                    'default' => '6',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Secondary Image Width:'),
                    'name' => 'listing_secondary_img_width',
                    'required' => false,
                    'class' => 't',
                    'default' => '390',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Secondary Image Height:'),
                    'name' => 'listing_secondary_img_height',
                    'required' => false,
                    'class' => 't',
                    'default' => '220',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Title:'),
                    'name' => 'listing_show_title',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Description:'),
                    'name' => 'listing_show_description',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Readmore:'),
                    'name' => 'listing_show_readmore',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Image:'),
                    'name' => 'listing_show_image',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Author:'),
                    'name' => 'listing_show_author',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Category:'),
                    'name' => 'listing_show_category',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Created Date:'),
                    'name' => 'listing_show_created',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Hits:'),
                    'name' => 'listing_show_hit',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Counter:'),
                    'name' => 'listing_show_counter',
                    'required' => false,
                    'class' => 't',
                    'default' => '1',
                    'values' => $onoff,
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-danger'
            )
        );

        $this->fields_form[2]['form'] = array(
            'tinymce' => true,
            'default' => '',
            // 'legend' => array(
                // 'title' => $this->l('Item Blog Setting'),
                // 'icon' => 'icon-folder-close'
            // ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Item Image Width:'),
                    'name' => 'item_img_width',
                    'required' => false,
                    'class' => 't',
                    'default' => '690',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Item Image Height:'),
                    'name' => 'item_img_height',
                    'required' => false,
                    'class' => 't',
                    'default' => '350',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Description:'),
                    'name' => 'item_show_description',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Image:'),
                    'name' => 'item_show_image',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Author:'),
                    'name' => 'item_show_author',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Category:'),
                    'name' => 'item_show_category',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Created Date:'),
                    'name' => 'item_show_created',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Hits:'),
                    'name' => 'item_show_hit',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Counter:'),
                    'name' => 'item_show_counter',
                    'required' => false,
                    'class' => 't',
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Social Sharing CODE'),
                    'name' => 'social_code',
                    'required' => false,
                    'default' => '',
                    'desc' => 'put sharing social code from sharethis service....to replace current sharing social.'
                ),
//                array(
//                    'type' => 'switch',
//                    'label' => $this->l('Comment Engine:'),
//                    'name' => 'item_comment_engine',
//                    'required' => false,
//                    'class' => 't',
//                    'default' => '1',
//                    'values' => $onoff,
//                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show List Comment:'),
                    'name' => 'item_show_listcomment',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                    'desc' => $this->l('Show/Hidden the list comment'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Form Comment:'),
                    'name' => 'item_show_formcomment',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                    'desc' => $this->l('This option just worked for the local comment'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Comment Engine:'),
                    'name' => 'item_comment_engine',
                    'id' => 'item_comment_engine',
                    'options' => array('query' => array(
                            array('id' => 'local', 'name' => $this->l('Local')),
                            array('id' => 'facebook', 'name' => $this->l('Facebook')),
                            array('id' => 'diquis', 'name' => $this->l('Diquis')),
                        ),
                        'id' => 'id',
                        'name' => 'name'),
                    'default' => 'local'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit Local Comment'),
                    'name' => 'item_limit_comments',
                    'required' => false,
                    'class' => 't',
                    'default' => '10',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Diquis Account:'),
                    'name' => 'item_diquis_account',
                    'required' => false,
                    'class' => 't',
                    'default' => 'demo4leotheme',
                    'desc' => '<a target="_blank" href="https://disqus.com/admin/signup/">'.$this->l('Sign Up Diquis').'</a>'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Facebook Application ID:'),
                    'name' => 'item_facebook_appid',
                    'required' => false,
                    'class' => 't',
                    'default' => '100858303516',
                    'desc' => '<a target="_blank" href="http://developers.facebook.com/docs/reference/plugins/comments/">'.$this->l('Register A Comment Box, Then Get Application ID in Script Or Register Facebook Application ID to moderate comments').'</a>'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Facebook Width:'),
                    'name' => 'item_facebook_width',
                    'required' => false,
                    'class' => 't',
                    'default' => '600'
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-danger'
            )
        );
        $this->fields_form[3]['form'] = array(
            'tinymce' => true,
            'default' => '',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Popular Blog'),
                    'name' => 'show_popular_blog',
                    'is_bool' => true,
                    'default' => '0',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit Popular Blog'),
                    'name' => 'limit_popular_blog',
                    'default' => '5',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Recent Blog'),
                    'name' => 'show_recent_blog',
                    'is_bool' => true,
                    'default' => '0',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit Recent Blog'),
                    'name' => 'limit_recent_blog',
                    'default' => '5',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show All Tags'),
                    'name' => 'show_all_tags',
                    'is_bool' => true,
                    'default' => '0',
                    'values' => $onoff,
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-danger'
            )
        );

        if (Configuration::get(Tools::strtoupper(_LEO_BLOG_PREFIX_.'template_current')) == 'default') {
            $data = LeoBlogConfig::getConfigValue('cfg_global');
        } else {
            $data = LeoBlogConfig::getConfigValue('cfg_global_'.Configuration::get(Tools::strtoupper(_LEO_BLOG_PREFIX_.'template_current')));
        }
           
        $obj = new stdClass();

        if ($data && $tmp = json_decode($data, true)) {
            foreach ($tmp as $key => $value) {
                # validate module
                $obj->{$key} = $value;
            }
        }
        $fields_value = $this->getConfigFieldsValues($obj);
        $fields_value['social_code'] = LeoBlogHelper::correctDeCodeData($fields_value['social_code']);
        $helper = new HelperForm($this);
        
        $this->setHelperDisplay($helper);
        // $helper->override_folder = 'test/';
        $helper->fields_value = $fields_value;
        $helper->tpl_vars = $this->tpl_form_vars;
        !is_null($this->base_tpl_form) ? $helper->base_tpl = $this->base_tpl_form : '';
        if ($this->tabAccess['view']) {
            $helper->tpl_vars['show_toolbar'] = false;
            $helper->tpl_vars['submit_action'] = 'saveConfiguration';
            if (Tools::getValue('back')) {
                $helper->tpl_vars['back'] = '';
            } else {
                $helper->tpl_vars['back'] = '';
            }
        }
        $form = $helper->generateForm($this->fields_form);
        $template = $this->createTemplate('panel.tpl');

        $comments = LeoBlogComment::getComments(null, 10, $this->context->language->id);
        $blogs = LeoBlogBlog::getListBlogs(null, $this->context->language->id, 0, 10, 'hits', 'DESC');

        $template->assign(array(
            'quicktools' => $quicktools,
            'showed' => 1,
            'comment_link' => $link->getAdminLink('AdminLeoblogComments'),
            'blog_link' => $link->getAdminLink('AdminLeoblogBlogs'),
            'blogs' => $blogs,
            'count_blogs' => LeoBlogBlog::countBlogs(null, $this->context->language->id),
            'count_cats' => Leoblogcat::countCats(),
            'count_comments' => LeoBlogComment::countComments(),
            'latest_comments' => $comments,
            'globalform' => $form,
            'default_tab' => Configuration::get('LEOBLOG_DASHBOARD_DEFAULTTAB')
        ));
        return $template->fetch();
    }

    /**
     * Asign value for each input of Data form
     */
    public function getConfigFieldsValues($obj)
    {
        $languages = Language::getLanguages(false);
        $fields_values = array();

        foreach ($this->fields_form as $k => $f) {
            foreach ($f['form']['input'] as $j => $input) {
                if (isset($input['lang'])) {
                    foreach ($languages as $lang) {
                        if (isset($obj->{trim($input['name']).'_'.$lang['id_lang']})) {
                            $data = $obj->{trim($input['name']).'_'.$lang['id_lang']};
                            $fields_values[$input['name']][$lang['id_lang']] = $data;
                        } else {
                            # validate module
                            $fields_values[$input['name']][$lang['id_lang']] = $input['default'];
                        }
                    }
                } else {
                    if (isset($obj->{trim($input['name'])})) {
                        $data = $obj->{trim($input['name'])};

                        if ($input['name'] == 'image' && $data) {
                            $thumb = __PS_BASE_URI__.'modules/'.$this->name.'/views/img/'.$data;
                            $this->fields_form[$k]['form']['input'][$j]['thumb'] = $thumb;
                        }

                        $fields_values[$input['name']] = $data;
                    } else {
                        # validate module
                        $fields_values[$input['name']] = $input['default'];
                    }
                }
            }
        }
        
        $fields_values['LEOBLOG_DASHBOARD_DEFAULTTAB'] = Tools::getValue('LEOBLOG_DASHBOARD_DEFAULTTAB', Configuration::get('LEOBLOG_DASHBOARD_DEFAULTTAB'));
        return $fields_values;
    }
    
    /**
     * PERMISSION ACCOUNT demo@demo.com
     * OVERRIDE CORE
     */
    public function initProcess()
    {
        parent::initProcess();
        
        if (count($this->errors) <= 0) {
            # EDIT
            if (!$this->access('edit')) {
                if (Tools::isSubmit('saveConfiguration') &&  Tools::getValue('saveConfiguration')) {
                    $this->errors[] = $this->trans('You do not have permission to edit this.', array(), 'Admin.Notifications.Error');
                }
            }
        }
    }
}
