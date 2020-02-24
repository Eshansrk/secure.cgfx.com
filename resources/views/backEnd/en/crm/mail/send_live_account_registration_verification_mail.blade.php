<style type="text/css">

   /*@import url('https://fonts.googleapis.com/css?family=Lato');*/

    body { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; background: #f1f1f1;}


</style>
<div style="Margin:0;">
    <center>
        <div class="m_7178298702458433966webkit">
            <table align="center" cellpadding="0" cellspacing="0" border="0" style="width:98%;Margin:0 auto;background-color:#ffffff">
                <tbody><tr>
                    <td style="font-size:0"></td>
                    <td align="center" valign="top" style="width:600px">
                        <table align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;border: 1px solid #d3d3d3;">
                            
                            <tbody>
                            <tr>
                                <td style="background-color:{{$mail_data['header_color']}}">
                                    <table cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;Margin:auto;table-layout:fixed" align="center">
                                        <tbody><tr>
                                            <td valign="top">
                                                <table align="center" cellpadding="0" cellspacing="0" border="0" style="height:100%;width:100%">
                                                    <tbody>
                                                    <tr>
                                                        <td valign="middle" align="left" style="padding:17px 20px; height:50px" height:"50px">
                                                            <a style="text-decoration:none" href="#" target="_blank">
                                                                <img mc:hideable="" mc:edit="" src="{{asset('img/logo.png')}}" height="40"; width="100">
                                                            </a>
                                                        </td>
                                                     <!-- <td valign="middle" align="right" style="padding:30px 20px">
                                                            <a style="text-decoration:none;color:#039ecd;" href="{{$mail_data['client_portal_url']}}" target="_blank">
                                                                Login Client Area
                                                            </a>
                                                        </td> -->
                                                    </tr>


                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" style="width:calc(100% - 40px);margin:auto;text-align:left;padding:30px 20px 0px" dir="ltr">
                                        <tbody>

                                        <tr>
                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 14px;font-weight: 600;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;">
                                                Dear 
                                               {{ $newAccount->fname }} {{ $newAccount->lname }},
                                            </td>
                                        </tr>

                                        <tr>
                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;text-align: left;">
                                                Thank you for choosing {{ $mail_data['company_name']}} as your Forex broker !
                                                In order to complete the registration process and confirm your email address, please follow the link:
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0" style="padding: 30px; border: 1px solid #d3d3d3; border-radius: 4px; width: 100%; text-align: center;margin: 15px 0;">
                                                    <tbody>
                                                    <tr>
                                                        <td mc:hideable="" mc:edit="" align="center" valign="middle" style="background-color: #039ecd;font-family: 'Lato', sans-serif;font-size: 16px;font-weight: 500;color: #FFFFFF;line-height: 12px;letter-spacing: 1px;padding: 13px 26px;border-radius: 4px; display: inline-block;">
                                                            <a data-color="Hero Button" href="{{ $link = url('/live-account-registration', $token).'?email='.urlencode($newAccount->email).'&account_type='.urlencode($account_type).'&leverage='.urlencode($leverage) }}" style="text-decoration:none; color:#FFFFFF; cursor: pointer;">Confirm Mail !</a>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                                                This is an automatically generated e-mail, please, do not reply! In order to avoid your information falling into
                                                the wrong hands, only you should have access to this letter. We strongly recommend that you store your
                                                log in details in as
                                                maximally secure a place as possible.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="20" align="center" valign="top" style="font-size:20px;line-height:20px;">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td mc:hideable="" mc:edit="" class="sectionDesc" align="left" valign="middle" style="font-family:'Open Sans',Arial,Helvetica,sans-serif;color:#039ecd;font-size:14px;line-height:22px;font-weight:400;letter-spacing:0px;background: #efefef;padding: 10px 20px;">
                                                Help and Support
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="20" align="center" valign="top" style="font-size:30px;line-height:30px;">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                                                {{$mail_data['company_name']}} has a dedicated support department operating 24 hours a day 5 days a week. Please do not hesitate to contact us using live chat or contact us form.<br>
                                                
                                               {{--  <a style="color: #039ecd" href="#">live chat</a> or <a style="color: #039ecd" href="#">contact us</a> form .<br> --}}

                                                Kind regards,<br>
                                                The {{$mail_data['company_name']}} Team
                                            </td>
                                        </tr> 

                                        <tr>
                                            <td height="8" align="center" valign="top" style="font-size:8px;line-height:8px;">&nbsp;</td>
                                        </tr>


                                        <tr>
                                            <td mc:hideable="" mc:edit="" class="sectionDesc" align="left" valign="middle" style="font-family:'Open Sans',Arial,Helvetica,sans-serif;color:#039ecd;font-size:14px;line-height:22px;font-weight:400;font-style: italic; letter-spacing:0px;background: #ffffff;">
                                                Contact Info :
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="10" align="center" valign="top" style="font-size:10px;line-height:10px;">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                    <tbody>
                                                    <tr>
                                                        <td mc:hideable="" mc:edit="" align="left" valign="middle" style="vertical-align: top; width: 50%">
                                                            <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 94%;">
                                                                <tbody>
                                                                <tr style="font-family: 'Lato', sans-serif;font-size: 12px;font-weight: 300;line-height: 20px;letter-spacing: 0px;color: #37393d;list-style: none;">
                                                <td>{{$general_info_others->address}}</td>
                                                                    <td></td>
                                                                </tr>
                                                               
                                                                </tbody>
                                                            </table>
                                                        </td>

                                                        <td mc:hideable="" mc:edit="" align="left" valign="middle" style="vertical-align: top;width: 50%">
                                                            <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 94%;">
                                                                <tbody>
                                                                
                                                                <tr style="font-family: 'Lato', sans-serif;font-size: 12px;font-weight: 300;line-height: 20px;letter-spacing: 0px;color: #37393d;list-style: none;">
                                                                    <td>Phone :</td>
                                                    <td>{{$general_info_others->phone}} </td>
                                                                </tr>
                                                                <tr style="font-family: 'Lato', sans-serif;font-size: 12px;font-weight: 300;line-height: 20px;letter-spacing: 0px;color: #37393d;list-style: none;">
                                                                    <td>Email :</td>
                                                    <td>{{$mail_data['support_email']}} </td>
                                                                </tr>
                                                                <tr style="font-family: 'Lato', sans-serif;font-size: 12px;font-weight: 300;line-height: 20px;letter-spacing: 0px;color: #37393d;list-style: none;">
                                                                    <td>Website:</td>
                                                        <td>{{$mail_data['company_url']}}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                    </tbody></table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="10" align="center" valign="top" style="font-size:10px;line-height:10px;">&nbsp;</td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 100%;background: #efefef;padding: 20px 40px;">

                                        <tbody>
                                        <tr>
                                            <td height="10" align="center" valign="top" style="font-size:10px;line-height:10px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td mc:hideable="" mc:edit="" align="left" valign="middle" style="font-family: 'Lato', sans-serif;font-size: 11px;font-weight: 300;line-height: 18px;letter-spacing: 0px;color: #797979;list-style: none;">
                                                {{$general_info_others->risk_warning_title}}:
                                                {!!$general_info_others->risk_warning_text!!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="24" align="center" valign="top" style="font-size:24px;line-height:24px;">&nbsp;</td>
                                        </tr>

                                        

                                        <tr>
                                            <td mc:hideable="" mc:edit="" align="center" valign="middle" style="    font-family: 'Lato', sans-serif;color: #67696f;font-size: 10px;line-height: 20px;font-weight: 400;letter-spacing: 0px;padding-top: 12px;">
                                                {{$general_info_others->copyright_text}}
                                            </td>
                                        </tr>

                                       

                                        </tbody></table>
                                </td>
                            </tr>




                            


                            

                        </tbody></table>
                    </td>
                    <td style="font-size:0"></td>
                </tr>
            </tbody></table>
        </div>
    </center>

</div></div>