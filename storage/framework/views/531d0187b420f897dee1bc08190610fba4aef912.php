<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

    <!-- START HEADER/BANNER -->

    <tbody>
        <tr>
            <td align="center">
                <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td align="center" valign="top" background="<?php echo e(asset('assets/images/dashboard/bg.png')); ?>"
                                bgcolor="#66809b" style="background-size:cover; background-position:top;height="
                                400""="">
                                <table class="col-600" width="600" height="400" border="0" align="center"
                                    cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td height="40"></td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="line-height: 0px;">
                                                <img style="display:block; line-height:0px; font-size:0px; border:0px;"
                                                    src="<?php echo e(asset('assets/images/logo/logo-trans.png')); ?>" width="109"
                                                    height="103" alt="logo">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-family: 'Raleway', sans-serif; font-size:37px; color:#ffffff; line-height:24px; font-weight: bold; letter-spacing: 7px;">
                                                SHERIN</td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-family: 'Lato', sans-serif; font-size:15px; color:#ffffff; line-height:24px; font-weight: 300;">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec dignissim
                                                ultrices dui, quis dictum eros venenatis sit amet. Nam gravida risus at
                                                nunc facilisis, sed feugiat massa commodo.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="50"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>


        <!-- END HEADER/BANNER -->


        <!-- START 3 BOX SHOWCASE -->

        <tr>
            <td align="center">
                <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0"
                    style="margin-left:20px; margin-right:20px; border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9;">
                    <tbody>
                        <tr>
                            <td height="35"></td>
                        </tr>

                        <tr>
                            <td align="center"
                                style="font-family: 'Raleway', sans-serif; font-size:22px; font-weight: bold; color:#2a3a4b;">
                                <?php echo e(trans('Configuration du compte Propriétaire')); ?></td>
                        </tr>

                        <tr>
                            <td height="10"></td>
                        </tr>


                        <tr>
                            <td align="center"
                                style="font-family: 'Lato', sans-serif; font-size:14px; color:#757575; line-height:24px; font-weight: 300;">
                                <?php echo e(trans('Bienvenu')); ?> ! <?php echo e($employ->firstname); ?> <br>
                                <?php echo e(trans('Vous etes un nouveau client Sherin')); ?>;
                                    <?php echo e(trans('Vous pouvez maintenant utiliser toutes nos service sur l\'application SHERIN')); ?>

                                .<br>
                                        
                            <th><?php echo e(trans('Magasin')); ?></th>
                            <td><?php echo e($store->name); ?></td>
                            <th><?php echo e(trans('Nom')); ?></th>
                            <td><?php echo e($employ->firstname); ?></td>
                            <th><?php echo e(trans('Prénom')); ?></th>
                            <td><?php echo e($employ->lastname); ?></td>
                            <th><?php echo e(trans('Téléphone')); ?></th>
                            <td><?php echo e($employ->phone); ?></td>
                            <th><?php echo e(trans('email')); ?></th>
                            <td><?php echo e($employ->email); ?></td>
                            <th><?php echo e(trans('Mot de passe')); ?></th>
                            <td><?php echo e($password); ?></td>
                                   
                            </td>
                        </tr>

                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr> -->
<!-- END FOOTER -->
</tbody>
</table>
