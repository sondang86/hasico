<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:          Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	controllers/jsjobs.php
  ^
 * Description: Controller class for application data
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class JSJobsControllerPurchaseHistory extends JSController {

    var $_router_mode_sef = null;

    function __construct() {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        if ($user->guest) { // redirect user if not login
            $link = 'index.php?option=com_user';
            $this->setRedirect($link);
        }
        $router = $app->getRouter();
        if ($router->getMode() == JROUTER_MODE_SEF) {
            $this->_router_mode_sef = 1; // sef true
        } else {
            $this->_router_mode_sef = 2; // sef false
        }

        parent :: __construct();
    }

    function savejobseekerpayment() { //save job seeker payment
        $data = JRequest :: get('post');
        $packageid = $data['packageid'];
        $packageid = $data['packageid'];
        $payment_method = $data['paymentmethod'];
        $package_forr = $data['packagefor'];
        ?>
        <div width="100%" align="center">
            <br><br><br><h2>Please wait</h2>

            <img src="components/com_jsjobs/images/working.gif" border="0" >
        </div>
        <?php
        $reser_med = date('misyHdmy');
        $reser_med = md5($reser_med);
        $reser_med = md5($reser_med);
        $reser_med1 = substr($reser_med, 0, 5);
        $reser_med2 .= substr($reser_med, 7, 13);
        $string = md5(time());
        $string = md5(time());
        $reser_start = substr($string, 0, 3);
        $reser_end = substr($string, 3, 2);
        $reference = $reser_start . $reser_med1 . $reser_med2 . $reser_end;
        $_SESSION['jsjobs_rfd_emppack'] = $reference;
        $Itemid = JRequest::getVar('Itemid');
        $packagehistory = $this->getmodel('Packagehistory', 'JSJobsModel');
        $return_value = $packagehistory->storePackageHistory(0, $data);
        if ($return_value != false) {
            $msg = JText :: _('JS_PACKAGE_SAVED');
            $paymentfor = JRequest::getVar('paymentmethod', '');
            $packagefor = JRequest::getVar('packagefor', '');
            if($packagefor == 1)
                $layout = 'employerpurchasehistory';
            else
                $layout = 'jobseekerpurchasehistory';
            if ($paymentfor != 'free') {
                $this->setRedirect('index.php?option=com_jsjobs&task=payment.onorder&orderid=' . $return_value . '&for=' . $paymentfor . '&packagefor=' . $packagefor);
            } else {
                if ($return_value === 'cantgetpackagemorethenone') {
                    $msg = JText :: _('JS_CAN_NOT_GET_FREE_PACKAGE_MORE_THEN_ONCE');
                    $link = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=' . $Itemid;
                    $this->setRedirect(JRoute::_($link), $msg);
                } elseif ($return_value == false) {
                    $msg = JText :: _('JS_ERROR_SAVING_PACKAGE');
                    $link = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=package_buynow&Itemid=' . $Itemid;
                    $this->setRedirect(JRoute::_($link), $msg);
                } else {
                    $msg = JText :: _('JS_PACKAGE_SAVED');
                    $link = 'index.php?option=com_jsjobs&c=purchasehistory&view=purchasehistory&layout='.$layout.'&Itemid=' . $Itemid;
                    $this->setRedirect(JRoute::_($link), $msg);
                }
            }
        } else {
            $msg = JText :: _('JS_ERROR_SAVING_PACKAGE');
            $link = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseekerpackages&layout=packages&Itemid=' . $Itemid;
            $this->setRedirect(JRoute::_($link), $msg);
        }
    }

    function saveemployerpayment() { //save employer payment
        $data = JRequest :: get('post');
        $packageid = $data['packageid'];
        $payment_method = $data['paymentmethod'];
        $package_forr = $data['packagefor'];
        ?>
        <div width="100%" align="center">
            <br><br><br><h2>Please wait</h2>

            <img src="components/com_jsjobs/images/working.gif" border="0" >
        </div>
        <?php
        $reser_med = date('misyHdmy');
        $reser_med = md5($reser_med);
        $reser_med = md5($reser_med);
        $reser_med1 = substr($reser_med, 0, 5);
        $reser_med2 .= substr($reser_med, 7, 13);
        $string = md5(time());
        $string = md5(time());
        $reser_start = substr($string, 0, 3);
        $reser_end = substr($string, 3, 2);
        $reference = $reser_start . $reser_med1 . $reser_med2 . $reser_end;
        $_SESSION['jsjobs_rfd_emppack'] = $reference;
        $Itemid = JRequest::getVar('Itemid');
        $packagehistory = $this->getmodel('Packagehistory', 'JSJobsModel');
        $return_value = $packagehistory->storePackageHistory(0, $data);
        if ($return_value != false) {
            $msg = JText :: _('JS_PACKAGE_SAVED');
            $paymentfor = JRequest::getVar('paymentmethod', '');
            $packagefor = JRequest::getVar('packagefor', '');
            if($packagefor == 1)
                $layout = 'employerpurchasehistory';
            else
                $layout = 'jobseekerpurchasehistory';
            if ($paymentfor != 'free') {
                $this->setRedirect(JRoute::_('index.php?option=com_jsjobs&task=payment.onorder&orderid=' . $return_value . '&for=' . $paymentfor . '&packagefor=' . $packagefor));
            } else {
                if ($return_value === 'cantgetpackagemorethenone') {
                    $msg = JText :: _('JS_CAN_NOT_GET_FREE_PACKAGE_MORE_THEN_ONCE');
                    $link = 'index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=' . $Itemid;
                    $this->setRedirect(JRoute::_($link), $msg);
                } elseif ($return_value == false) {
                    $msg = JText :: _('JS_ERROR_SAVING_PACKAGE');
                    $link = 'index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=package_buynow&Itemid=' . $Itemid;
                    $this->setRedirect(JRoute::_($link), $msg);
                } else {
                    $msg = JText :: _('JS_PACKAGE_SAVED');
                    $link = 'index.php?option=com_jsjobs&c=purchasehistory&view=purchasehistory&layout='.$layout.'&Itemid=' . $Itemid;
                    $this->setRedirect(JRoute::_($link), $msg);
                }
            }
        } else {
            $msg = JText :: _('JS_ERROR_SAVING_PACKAGE');
            $link = 'index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=package_buynow&Itemid=' . $Itemid;
            $this->setRedirect(JRoute::_($link), $msg);
        }
    }

    function display($cachable = false, $urlparams = false) { // correct purchasehistory controller display function manually.
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'resume');
        $layoutName = JRequest :: getVar('layout', 'jobcat');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $view->setLayout($layoutName);
        $view->display();
    }

}
?>
    