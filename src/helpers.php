<?php
  namespace Sirius\Builder;

  use think\Template;

  /**
   * @param string $template_file 模板文件
   * @param array $var  模板变量
   * @param array $config 配置
   *
   * @return string
   */
  function template( $template_file, $var=[], $config=[]){
    static $template=null;

    if (is_null( $template)){
      var_dump( 'new instance');
      $template=new Template($config);
    }

    $template->config( $config);
    $template->assign($var);

    ob_start();
    ob_implicit_flush(false);
    $template->fetch($template_file);
    $content=ob_get_clean();

    return $content;

  }
