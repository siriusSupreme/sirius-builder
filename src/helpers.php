<?php
  namespace Sirius\Builder;

  use think\Template;

  if (!function_exists( '\Sirius\Builder\template')){
    /**
     * @param string $template_file
     * @param array $var
     * @param array $config
     *
     * @return string
     */
    function template($template_file,$var=[],$config=[]){
      static $template=null;

      if (is_null( $template)){
        $template=new Template($config);
      }

      $template->config($config);
      $template->assign($var);

      ob_start();
      ob_implicit_flush(false);
      $template->fetch($template_file);
      $content=ob_get_clean();

      return $content;

    }
  }

if (!function_exists('\Sirius\Builder\admin_path')) {

    /**
     * Get admin path.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_path($path = '')
    {
        return ucfirst(config('admin.directory')).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('\Sirius\Builder\admin_url')) {
    /**
     * Get admin url.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_url($path = '')
    {
        if (\Sirius\Support\Facades\URL::isValidUrl($path)) {
            return $path;
        }

        return url(admin_base_path($path));
    }
}

if (!function_exists('\Sirius\Builder\admin_base_path')) {
    /**
     * Get admin url.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_base_path($path = '')
    {
        $prefix = '/'.trim(config('admin.route.prefix'), '/');

        $prefix = ($prefix == '/') ? '' : $prefix;

        return $prefix.'/'.trim($path, '/');
    }
}

if (!function_exists('\Sirius\Builder\admin_toastr')) {

    /**
     * Flash a toastr message bag to session.
     *
     * @param string $message
     * @param string $type
     * @param array  $options
     *
     * @return string
     */
    function admin_toastr($message = '', $type = 'success', $options = [])
    {
        $toastr = new \Sirius\Support\MessageBag(get_defined_vars());

        \Sirius\Support\Facades\Session::flash('toastr', $toastr);
    }
}

if (!function_exists('\Sirius\Builder\admin_asset')) {

    /**
     * @param $path
     *
     * @return string
     */
    function admin_asset($path)
    {
        return asset($path, config('admin.secure'));
    }
}
