<div id="box">
    <h2 class="title_h2">标题标题标题标题</h2>
    <?php $patient = $model->patient;?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_c">
        <tr>
            <td>I     D：</td>
            <td><?php echo $patient->id;?></td>
            <td>姓    名：</td>
            <td><?php echo $patient->name;?></td>
            <td>年    龄：</td>
            <td><?php echo $model->patient_age;?>岁</td>
        </tr>
        <tr>
            <td>性    别：</td>
            <td><?php echo $patient->sex == Patient::SEX_FEMAL ? '女' : '男'; ?></td>
            <td>打印状态：</td>
            <td><?php echo $model->print == PatientTestRecord::PRINT_YES ? '已打印' : '未打印'; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>科    别：</td>
            <td><?php echo $model->department->name;?></td>
            <td>床    号：</td>
            <td><?php echo $model->bed_no;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>标本类型：</td>
            <td><?php echo $model->sample;?></td>
            <td>送检医生：</td>
            <td><?php echo $model->doctor->name;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>临床诊断：</td>
            <td><?php echo $model->diagnoses; ?></td>
            <td>检验组合：</td>
            <td><?php echo $model->test_item; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>设备型号：</td>
            <td><?php echo $model->device->number; ?></td>
            <td>报告单格式：</td>
            <td><?php //echo $model->category->name;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>检验师：</td>
            <td><?php echo $model->operator->name;?></td>
            <td>核对者：</td>
            <td><?php echo $model->checker->name;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>采样时间：</td>
            <td><?php echo date("Y-m-d", $model->sample_time);?></td>
            <td>送检时间：</td>
            <td><?php echo date("Y-m-d", $model->test_time); ?></td>
            <td>报告时间：</td>
            <td><?php echo date("Y-m-d", $model->reporting_time);?></td>
        </tr>
        <tr>
            <td>仪器设备：</td>
            <td colspan="5"><?php echo $model->device->name;?></td>
        </tr>
        <tr>
            <td>备    注：</td>
            <td colspan="5"><?php echo $model->remark;?></td>
        </tr>
    </table>
</div>