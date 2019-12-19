<?php
namespace CBB_WorkWithUs\Admin\Exports;

class JobApplication
{
    private $headers;

    public function __construct()
    {
        $this->headers = array();
    }

    public function generateExcel()
    {
        $objPHPExcel = new \PHPExcel();

        $filename = 'reporte.xlsx';
        $title = 'Relación de Postulaciones';

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Postulaciones');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal( \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

        $this->generateHeaderExcel($objPHPExcel);
        $this->generateCellsExcel($objPHPExcel);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        exit;
    }

    private function generateHeaderExcel(\PHPExcel $excel)
    {
        $headers = $this->setHeaders();
        if (count($headers)) {
            foreach ($headers as $key => $value) {
                $excel->getActiveSheet()->setCellValue($key, $value);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setSize(11);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle($key)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }
    }

    private function setHeaders()
    {
        $this->headers = array(
            'A3' => 'Nombre',
            'B3' => 'Correo electrónico',
            'C3' => 'Documento',
            'D3' => 'Género',
            'E3' => 'Fecha de Nacimiento',
            'F3' => 'Edad',
            'G3' => 'Tel. Fijo',
            'H3' => 'Celular',
            'I3' => 'Departamento',
            'J3' => 'Provincia',
            'K3' => 'Distrito',
            'L3' => 'Dirección',
            'M3' => 'Referencia',
            'N3' => 'Nivel',
            'O3' => 'Sede',
            'P3' => 'Reseña',
            'Q3' => 'Tipo Postulación'
        );
        return $this->headers;
    }

    private function generateCellsExcel(\PHPExcel $excel)
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'jobapplications',
        );

        $i = 4;
        $the_query = new \WP_Query($args);
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $id = get_the_ID();
                $values = get_post_custom($id);
                $name = !empty($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
                $firstName = !empty($values['mb_ape_paterno']) ? esc_attr($values['mb_ape_paterno'][0]) : '';
                $lastName = !empty($values['mb_ape_materno']) ?  esc_attr($values['mb_ape_materno'][0]) : '';
                $document = !empty($values['mb_document']) ?  esc_attr($values['mb_document'][0]) : '';
                $gender = !empty($values['mb_gender']) ? esc_attr($values['mb_gender'][0]) : '';
                $birthday = !empty($values['mb_birthday']) ? esc_attr(date('d-m-Y' , strtotime($values['mb_birthday'][0]))) : '';
                $age = !empty($values['mb_age']) ? esc_attr($values['mb_age'][0]) : '';
                $phone = !empty($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
                $mobile = !empty($values['mb_mobile']) ? esc_attr($values['mb_mobile'][0]) : '';
                $email = !empty($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
                $city = !empty($values['mb_city']) ? esc_attr($values['mb_city'][0]) : '';
                $province = !empty($values['mb_province']) ? esc_attr($values['mb_province'][0]) : '';
                $district = !empty($values['mb_district']) ? esc_attr($values['mb_district'][0]) : '';
                $address = !empty($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
                $reference = !empty($values['mb_reference']) ? esc_attr($values['mb_reference'][0]) : '';
                $review = !empty($values['mb_review']) ? esc_attr($values['mb_review'][0]) : '';
                $local = !empty($values['mb_local']) ? (int)esc_attr($values['mb_local'][0]) : '';
                $levelEducation = !empty($values['mb_level_education']) ? esc_attr($values['mb_level_education'][0]) : '';

                $dataLocal = '';
                if (!empty($local)) {
                    $dataLocal = get_post($local);
                }

                $typePostulation = wp_get_object_terms($id, 'joblevels');
                $typePostulation = !is_wp_error($typePostulation) ? $typePostulation[0]->name : '';

                $excel->getActiveSheet()->setCellValue('A'.$i, "{$name} {$firstName} {$lastName}");
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('B'.$i, $email);
                $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('C'.$i, $document);
                $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('D'.$i, $gender);
                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('E'.$i, $birthday);
                $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('F'.$i, $age);
                $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('G'.$i, $phone);
                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('H'.$i, $mobile);
                $excel->getActiveSheet()->getStyle('H'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('I'.$i, $city);
                $excel->getActiveSheet()->getStyle('I'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('J'.$i, $province);
                $excel->getActiveSheet()->getStyle('J'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('K'.$i, $district);
                $excel->getActiveSheet()->getStyle('K'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('L'.$i, $address);
                $excel->getActiveSheet()->getStyle('L'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('M'.$i, $reference);
                $excel->getActiveSheet()->getStyle('M'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('N'.$i, $levelEducation);
                $excel->getActiveSheet()->getStyle('N'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('O'.$i, is_object($dataLocal) ? $dataLocal->post_title : $dataLocal);
                $excel->getActiveSheet()->getStyle('O'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('P'.$i, $review);
                $excel->getActiveSheet()->getStyle('P'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('Q'.$i, $typePostulation);
                $excel->getActiveSheet()->getStyle('Q'.$i)->getFont()->setSize(10);

                ++$i;
            }
        }

        wp_reset_postdata();
    }
}
