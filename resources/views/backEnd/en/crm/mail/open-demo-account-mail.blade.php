<style type="text/css">

   /* @import url('https://fonts.googleapis.com/css?family=Lato');*/

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
                                                        <td valign="middle" align="left" style="padding:17px 20px">
                    <a style="text-decoration:none" href="#" target="_blank">
                    <img mc:hideable="" mc:edit="" src="{{asset('img/logo.png')}}" height="40"; width="100">
                                                            </a>
                                                        </td>
                                                        <td valign="middle" align="right" style="padding:30px 20px">
                         <a style="text-decoration:none;color:#039ecd;" href="{{$mail_data['client_portal_url']}}" target="_blank">
                                                                Login Client Area
                                                            </a>
                                                        </td>
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
                                                <td height="28" align="center" valign="top" style="font-size:28px;line-height:28px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 14px;font-weight: 600;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;">
                                                    Demo Trading Account Details
                                                </td>
                                            </tr>

                                        <tr>
                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 14px;font-weight: 600;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;">
                                                Dear {{ $name }},
                                            </td>
                                        </tr>

                                        <tr>
                                                <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                                                    Your demo trading account has been created on our trading server. You can log into your account using the details below.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="28" align="center" valign="top" style="font-size:28px;line-height:28px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:600;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">Your demo trading account login details:</td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:600;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">Trading Platform: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; MT4</td>
                                            </tr> -->
                                            <tr>
                                                <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:600;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">Login:  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   {{$login}}</td>
                                            </tr>
                                            <tr>
                                                <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:600;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">Password:&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; {{ $password }}</td>
                                            </tr>
                                            <tr>
                                                <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:600;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">Investor Password: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;   {{$investor_password}}</td>
                                            </tr>
                                            <tr>
                                                <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:600;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">Server:&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;    {{$mail_data['server_client']}}</td>
                                            </tr>
                                            

                                        <tr>
                                                <td align="left" valign="top">
                                                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="background-color: #efefef; border-radius: 4px; width: 100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td mc:hideable="" mc:edit="" class="sectionDesc" align="left" valign="middle" style="font-family:'Open Sans',Arial,Helvetica,sans-serif;color:#2ED57F;font-size:14px;line-height:22px;font-weight:600;letter-spacing:0px;background: #efefef;padding: 10px 20px;">
                                                                    How to login to your MetaTrader account 
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                </td>
                                            </tr>

                                            <tr>
                                                <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;padding-top:15px;">
                                                    You can download the MetaTrader trading account from inside your secure client area by clicking on the link below: <a href="{{$mail_data['download_link']}}">Download Trading Platform </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;border-bottom: 1px solid #ddd">
                                                    After downloading the MetaTrader Trading platform please follow the steps below to log into your account.
                                                </td>
                                            </tr>
                                             <tr>
                                            <td height="20" align="center" valign="top" style="font-size:20px;line-height:20px;">&nbsp;</td>
                                        </tr>
                                            <tr>
                                                <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:10px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                                                   <span style="font-weight: bold;">Step 1.</span> Select File &gt; Login
                                                </td>
                                            </tr>

                                            <tr>
                                    <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:10px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                                       <span style="font-weight: bold;">Step 2.</span> Enter your login details as outlined above
                                    </td>
                                </tr>
                                <tr>
                                    <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:10px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                    <span style="font-weight: bold;">Step 3.</span> Select your server <span style="font-weight: bold"> {{$mail_data['server_client']}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:10px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                                       <span style="font-weight: bold;">Step 4.</span> Click the "Login" button
                                    </td>
                                </tr>
                                 <tr>
                                            <td height="20" align="center" valign="top" style="font-size:20px;line-height:20px;">&nbsp;</td>
                                        </tr>
                                <tr>
                                    <td mc:hideable="" mc:edit="" class="sectionDesc" align="left" valign="middle" style="font-family:'Open Sans',Arial,Helvetica,sans-serif;color:#2ED57F;font-size:14px;line-height:22px;font-weight:600;letter-spacing:0px;background: #efefef;padding: 10px 20px;">
                                        Help and Support
                                    </td>
                                </tr>

                                       

                                        <tr>
                                            <td height="20" align="center" valign="top" style="font-size:30px;line-height:30px;">&nbsp;</td>
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
                                                    <td>{{$general_info_others->phone}}</td>
                                                                </tr>
                                                                <tr style="font-family: 'Lato', sans-serif;font-size: 12px;font-weight: 300;line-height: 20px;letter-spacing: 0px;color: #37393d;list-style: none;">
                                                                    <td>Email :</td>
                                                                    <td>{{$mail_data['support_email']}} </td>
                                                                </tr>
                                                                <tr style="font-family: 'Lato', sans-serif;font-size: 12px;font-weight: 300;line-height: 20px;letter-spacing: 0px;color: #37393d;list-style: none;">
                                                                    <td>Website:</td>
                                                                    <td>{{$mail_data['company_url']}} </td>
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