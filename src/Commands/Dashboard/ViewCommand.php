<?php

namespace Pantheon\Terminus\Commands\Dashboard;

use Pantheon\Terminus\Commands\TerminusCommand;
use Pantheon\Terminus\Site\SiteAwareInterface;
use Pantheon\Terminus\Site\SiteAwareTrait;

class ViewCommand extends TerminusCommand implements SiteAwareInterface
{
    use SiteAwareTrait;

    /**
     * Open the Pantheon site dashboard in a browser
     *
     * @command dashboard:view
     * @aliases dashboard
     *
     * @option string $site_env Site & environment to deploy to, in the form `site-name.env`
     * @option boolean $print Don't try to open the link, just output it
     *
     * @usage terminus dashboard my-awesome-site.env-name --print
     *   Deploy from dev to test environment
     */
    public function deploy($site_env = null, $options = ['print' => false,])
    {
        switch (php_uname('s')) {
            case 'Linux':
                $cmd = 'xdg-open';
                break;
            case 'Darwin':
                $cmd = 'open';
                break;
            case 'Windows NT':
                $cmd = 'start';
                break;
        }

        if ($site_env) {
            list(, $env) = $this->getSiteEnv($site_env, 'dev');
            $url = $env->dashboardUrl();
        } else {
            $url = $this->session()->getUser()->dashboardUrl();
        }

        if ($options['print']) {
            return $url;
        } else {
            $command = sprintf('%s %s', $cmd, $url);
            exec($command);
        }
    }
}
