<?php
defined('_PATH') or die('Restricted!');

class ControllerMattersNewJob extends Controller {
    private $error = array();

    public function form() {
        $this->data = $this->load->language('matters/new_job');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->document->addScript('view/javascript/datetimepicker/moment.js');
        $this->document->addScript('view/javascript/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('view/javascript/datetimepicker/bootstrap-datetimepicker.min.css');

        $url = $this->build->url(array(
            'filter_recurring_id',
            'filter_name',
            'filter_total',
            'filter_status',
            'filter_cycle',
            'filter_date_due',
            'filter_date_added',
            'filter_date_modified',
            'sort',
            'order',
            'page',
            'recurring_id'
        ));

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('matters/new_job/form', 'token=' . $this->session->data['token'], true)
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('matters/new_job/form', 'token=' . $this->session->data['token'] . $url, true)
        );

        $this->load->model('billing/recurring');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            // if (isset($this->request->get['recurring_id'])) {
            //     $this->model_billing_recurring->editRecurring((int)$this->request->get['recurring_id'], $this->request->post);
            // } else {
            //     $this->model_billing_recurring->addRecurring($this->request->post);
            // }

            // $this->session->data['success'] = $this->language->get('text_success');

      echo $this->request->get['matterid'];

            $this->response->redirect($this->url->link('matters/view', 'token=' . $this->session->data['token'] . $url, true));
        }

        if (isset($this->request->get['recurring_id'])) {
            $recurring_info = $this->model_billing_recurring->getRecurring((int)$this->request->get['recurring_id']);
        } else {
            $recurring_info = array();
        }

        $this->data['action'] = $this->url->link('matters/new_job/form', 'token=' . $this->session->data['token'] . $url, true);

        $this->data['cancel'] = $this->url->link('matters/view', 'token=' . $this->session->data['token'] . $url, true);

        $this->data['token'] = $this->session->data['token'];

        $this->data['error_warning'] = $this->build->data('warning', $this->error);

        $this->data['recurring_id'] = $this->build->data('recurring_id', $this->request->post, $recurring_info);
        $this->data['customer_id'] = $this->build->data('customer_id', $this->request->post, $recurring_info);
        $this->data['customer'] = $this->build->data('customer', $this->request->post, $recurring_info);
        $this->data['payment_code'] = $this->build->data('payment_code', $this->request->post, $recurring_info);
        $this->data['payment_name'] = $this->build->data('payment_name', $this->request->post, $recurring_info);
        $this->data['payment_description'] = $this->build->data('payment_description', $this->request->post, $recurring_info);
        $this->data['currency_code'] = $this->build->data('currency_code', $this->request->post, $recurring_info, $this->config->get('config_currency'));
        $this->data['currency_value'] = $this->build->data('currency_value', $this->request->post, $recurring_info, '1.00');
        $this->data['comment'] = $this->build->data('comment', $this->request->post, $recurring_info);
        $this->data['status'] = $this->build->data('status', $this->request->post, $recurring_info, '1');
        $this->data['cycle'] = $this->build->data('cycle', $this->request->post, $recurring_info);
        $this->data['date_due'] = $this->build->data('date_due', $this->request->post, $recurring_info);
        $this->data['items'] = $this->build->data('items', $this->request->post, $recurring_info, array());
        $this->data['totals'] = $this->build->data('totals', $this->request->post, $recurring_info, array());

        $this->load->model('extension/extension');

        $payments = $this->model_extension_extension->getInstalled('payment');

        $this->data['payments'] = array();

        foreach ($payments as $payment) {
            if ($this->config->get($payment . '_status')) {
                $this->load->language('payment/' . $payment . '/' . $payment);

                $this->data['payments'][] = array(
                    'name'       => $this->language->get('heading_title'),
                    'code'       => $payment,
                    'sort_order' => $this->config->get($payment . '_sort_order')
                );
            }
        }

        $sort_order = array();

        foreach ($this->data['payments'] as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $this->data['payments']);

        $this->load->model('accounting/currency');

        $this->data['currencies'] = $this->model_accounting_currency->getCurrencies();

        $this->data['default_currency_code'] = $this->config->get('config_currency');

        $this->load->model('system/status');

        $this->data['statuses'] = $this->model_system_status->getStatuses();

        $this->load->model('accounting/tax_class');

        $this->data['tax_classes'] = $this->model_accounting_tax_class->getTaxClasses();
        $this->data['law_firms'] = $this->db->query("SELECT * FROM lawfirm")->rows;
         $this->data['associates'] = $this->db->query("SELECT * FROM associates")->rows;

        $this->data['header'] = $this->load->controller('common/header');
        $this->data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->render('matters/new_job_form'));
    }

    public function view() {
        $this->data = $this->load->language('billing/recurring');

        $this->document->setTitle($this->language->get('heading_title'));

        $url = $this->build->url(array(
            'filter_recurring_id',
            'filter_name',
            'filter_total',
            'filter_status',
            'filter_cycle',
            'filter_date_due',
            'filter_date_added',
            'filter_date_modified',
            'sort',
            'order',
            'page',
            'recurring_id'
        ));

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('matters/view', 'token=' . $this->session->data['token'] . $url, true)
        );

        $this->load->model('billing/recurring');

        $recurring_info = $this->model_billing_recurring->getRecurring((int)$this->request->get['recurring_id']);

        if ($recurring_info) {
            $this->data['filter'] = $this->url->link('billing/invoice', 'token=' . $this->session->data['token'] . '&filter_recurring_id=' . $recurring_info['recurring_id'], true);
            $this->data['cancel'] = $this->url->link('billing/recurring', 'token=' . $this->session->data['token'] . $url, true);

            $this->data['token'] = $this->session->data['token'];

            $this->data['recurring_id'] = $recurring_info['recurring_id'];
            $this->data['customer_href'] = $this->url->link('billing/customer/form', 'token=' . $this->session->data['token'] . '&customer_id=' . $recurring_info['customer_id'], true);
            $this->data['customer'] = $recurring_info['customer'];
            $this->data['payment_name'] = $recurring_info['payment_name'];
            $this->data['payment_description'] = $recurring_info['payment_description'];
            $this->data['currency_value'] = $recurring_info['currency_value'];
            $this->data['comment'] = nl2br($recurring_info['comment']);
            $this->data['status'] = $recurring_info['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled');
            $this->data['cycle'] = $this->language->get('text_' . $recurring_info['cycle']);
            $this->data['date_due'] = $recurring_info['date_due'];

            $this->load->model('extension/extension');

            $payments = $this->model_extension_extension->getInstalled('payment');

            $this->data['payment_code'] = $recurring_info['payment_code'];

            foreach ($payments as $payment) {
                if ($this->config->get($payment . '_status') && $payment == $recurring_info['payment_code']) {
                    $this->load->language('payment/' . $payment . '/' . $payment);

                    $this->data['payment_code'] = $this->language->get('heading_title');
                }
            }

            $this->load->model('accounting/currency');

            $currencies = $this->model_accounting_currency->getCurrencies();

            $this->data['currency_code'] = $recurring_info['currency_code'];

            foreach ($currencies as $currency) {
                if ($currency['code'] == $recurring_info['currency_code']) {
                    $this->data['currency_code'] = $currency['title'];
                }
            }

            $items = $recurring_info['items'];

            $this->data['items'] = array();

            $number = 1;

            foreach ($items as $item) {
                $this->data['items'][] = array(
                    'number'      => $number,
                    'title'       => html_entity_decode($item['title'], ENT_QUOTES),
                    'description' => html_entity_decode(nl2br($item['description']), ENT_QUOTES),
                    'quantity'    => $item['quantity'],
                    'price'       => $this->currency->format($item['price'], $recurring_info['currency_code'], $recurring_info['currency_value']),
                    'discount'    => (float)$item['discount'] ? $this->currency->format($item['discount'], $recurring_info['currency_code'], $recurring_info['currency_value']) : '-',
                    'total'       => $this->currency->format(($item['price'] - $item['discount']) * $item['quantity'], $recurring_info['currency_code'], $recurring_info['currency_value'])
                );

                $number++;
            }

            $totals = $recurring_info['totals'];

            $this->data['totals'] = array();

            foreach ($totals as $total) {
                $this->data['totals'][] = array(
                    'title' => html_entity_decode($total['title'], ENT_QUOTES),
                    'text'  => $this->currency->format($total['value'], $recurring_info['currency_code'], $recurring_info['currency_value'])
                );
            }

            $this->data['header'] = $this->load->controller('common/header');
            $this->data['footer'] = $this->load->controller('common/footer');

            $this->response->setOutput($this->render('billing/recurring_view'));
        } else {
            return new Action('error/not_found');
        }
    }

    public function update() {
        $this->load->language('billing/recurring');

        $json = array();

        $recurring_id = (int)$this->request->post['recurring_id'];
        $status = (int)$this->request->post['status'];

        if (!$this->user->hasPermission('modify', 'billing/recurring')) {
            $json['warning'] = $this->language->get('error_permission');
        } else {
            $this->load->model('billing/recurring');

            $this->model_billing_recurring->editStatus($recurring_id, $status);

            $json['success'] = $this->language->get('text_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'billing/recurring')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'billing/recurring')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function validate_step_1() {
        $this->load->language('matters/new_job');

        $json = array();

        if (!$this->request->post['matterid']) {
            $json['matterid'] = $this->language->get('error_matterid');
        }

        if (!$this->request->post['date_due']) {
            $json['date_due'] = $this->language->get('error_date_due');
        }

        if (!$json) {
            $json['success'] = true;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function validate_step_2() {
        $this->load->language('billing/recurring');

        $json = array();

        if (!$this->request->post['payment_name']) {
            $json['payment_name'] = $this->language->get('error_payment_name');
        }

        if (!$this->request->post['currency_code']) {
            $json['currency_code'] = $this->language->get('error_currency_code');
        }

        if (!(float)$this->request->post['currency_value']) {
            $json['currency_value'] = $this->language->get('error_currency_value');
        }

        if (!$json) {
            $json['success'] = true;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function validate_step_3() {
        $json = array();

        $this->load->model('accounting/tax_class');

        if (isset($this->request->post['items'])) {
            $taxes = array();
            $total = 0;

            $json['items'] = array();

            $number = 1;

            foreach ($this->request->post['items'] as $key => $item) {
                $tax = 0;

                $tax_class_info = $this->model_accounting_tax_class->getTaxClass($item['tax_class_id']);

                if ($tax_class_info) {
                    foreach ($tax_class_info['tax_rates'] as $tax_rate) {
                        if ($tax_rate['type'] == 'P') {
                            $tax = ((float)$item['price'] - (float)$item['discount']) / 100 * $tax_rate['rate'];
                        } else {
                            $tax = $tax_rate['rate'];
                        }

                        if (isset($taxes[$tax_rate['tax_rate_id']])) {
                            $value = $tax * (int)$item['quantity'] + $taxes[$tax_rate['tax_rate_id']]['value'];
                        } else {
                            $value = $tax * (int)$item['quantity'];
                        }

                        $taxes[$tax_rate['tax_rate_id']] = array(
                            'name'  => $tax_rate['name'],
                            'value' => $value
                        );
                    }
                }

                $total += ((float)$item['price'] - (float)$item['discount']) * (int)$item['quantity'];

                $json['items'][] = array(
                    'key'         => $key,
                    'number'      => $number,
                    'title'       => $item['title'],
                    'description' => nl2br($item['description']),
                    'quantity'    => $item['quantity'],
                    'tax'         => $tax,
                    'price'       => $this->currency->format((float)$item['price'], $this->request->post['currency_code'], (float)$this->request->post['currency_value']),
                    'discount'    => (float)$item['discount'] ? $this->currency->format((float)$item['discount'], $this->request->post['currency_code'], (float)$this->request->post['currency_value']) : '-',
                    'total'       => $this->currency->format((((float)$item['price'] - (float)$item['discount']) * (int)$item['quantity']), $this->request->post['currency_code'], (float)$this->request->post['currency_value'])
                );

                $number++;
            }

            $this->load->model('extension/extension');

            $sort_order = array();

            $results = $this->model_extension_extension->getInstalled('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            $total_data = array();

            foreach ($results as $result) {
                if ($this->config->get($result . '_status')) {
                    $this->load->model('total/' . $result . '/' . $result);

                    $this->{'model_total_' . $result . '_' . $result}->getTotal($total_data, $total, $taxes);
                }
            }

            $json['totals'] = array();

            foreach ($total_data as $total) {
                $json['totals'][] = array(
                    'code'       => $total['code'],
                    'title'      => $total['title'],
                    'text'       => $this->currency->format($total['value'], $this->request->post['currency_code'], $this->request->post['currency_value']),
                    'value'      => $total['value'],
                    'sort_order' => $total['sort_order']
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}