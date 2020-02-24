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
                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 14px;font-weight: 600;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;">
                                                Dear {{ $intIds->fname }} {{ $intIds->lname }},
                                            </td>
                                        </tr>


                                        <tr>
                                           <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 14px;font-weight: 600;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;">
                                               Your email has been verified successfully.
                                            </td> 
                                        </tr>

                                        <tr>
                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;text-align: left;">
                                                Thank you for choosing to trade with {{$mail_data['company_name']}}, please find the login details below for your secure client area.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 14px;font-weight: 400;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;padding-top: 7px">
                                                Your Secure Area Login Details:
                                            </td>
                                        </tr>

            
                                        <tr>
                                             <td align="center" valign="top">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0" style="padding: 30px; border: 1px solid #d3d3d3; border-radius: 4px; width: 100%; text-align: center;margin: 15px 0;">
                                                    <tbody>
                                                    <tr>
                                                        
 
                                                         

                                                        <tr>
                                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 12px;font-weight: 400;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;padding-top: 7px">
                                                                Login Url : <a href="{{$mail_data['client_portal_url']}}" target="blank">{{$mail_data['client_portal_url']}}

                                                            </td>
                                                        </tr>
                                                        
 <tr>
                                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 12px;font-weight: 400;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;padding-top: 7px">
                                                    Login Trading ID : {{$mt4_login}}
                                                            </td>
                                                        </tr>

 <tr>
                                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 12px;font-weight: 400;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;padding-top: 7px">
                                                   Trading Password : {{ $mt4_password }}
                                                            </td>
                                                        </tr>


 <tr>
                                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 12px;font-weight: 400;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;padding-top: 7px">
                                                 Investor Password : {{$investor_password}}
                                                            </td>
                                                        </tr>

 <tr>
                                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 12px;font-weight: 400;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;padding-top: 7px">
                                                   Server : {{$mail_data['server_client']}}
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family: 'Lato', sans-serif;color: #37393d;font-size: 12px;font-weight: 400;letter-spacing: 0px;padding: 0;padding-bottom: 7px;text-align: left;padding-top: 7px">
                                                     Download MetaTrade : <a href="{{$mail_data['download_link']}}">Download Here
                                                            </td>
                                                        </tr>


                                                    </tr>
                                                    </tbody></table>
                                            </td>
                                        </tr>


                                        <tr>
                                                <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">From inside your secure client area you can easily change your password, account details, open additional accounts, deposit funds, withdraw funds and transfer funds between accounts.</td>
                                            </tr>
   <tr>
                                                <td align="left" valign="top">
                                                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="background-color: #efefef; border-radius: 4px; width: 100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td mc:hideable="" mc:edit="" class="sectionDesc" align="left" valign="middle" style="font-family:'Open Sans',Arial,Helvetica,sans-serif;color:#2ED57F;font-size:14px;line-height:22px;font-weight:600;letter-spacing:0px;background: #efefef;padding: 10px 20px;">
                                                                    Please ensure that you have your ID ready 
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;padding-top:15px;">
                                                    As part of our requirements you are required to provide us with your identification. Once you activate your secure client area you will be asked to upload your identification documents. Please ensure that you have one form of Photo ID in addition to a document verifying your Proof of Residence ready for upload. Accepted forms of ID are listed below:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="heroSubTitle" align="left" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:16px;line-height:20px;font-weight:600;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left; border-bottom: 1px solid #ddd">
                                                    Photo ID, <br>
                                                    <table align="left">
                                                        <tbody>
                                                            <tr>
                                                                <td class="heroSubTitle" align="left" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0; text-align: left;padding-top: 15px;position: relative;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   <span style="width: 6px;
    height: 6px;
    background: #000;
    border-radius: 3px;
    display: inline-block;
    margin-right: 5px;"></span>Valid Passport 
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="heroSubTitle" align="left" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:0px;font-weight:400;letter-spacing:0px;padding:0; text-align: left;padding-top: 15px;position: relative;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="width: 6px;
    height: 6px;
    background: #000;
    border-radius: 3px;
    display: inline-block;
    margin-right: 5px;"></span>Valid Government ID, such as a Drivers Licence or State ID 
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="heroSubTitle" align="left" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0; text-align: left;padding-top: 15px;padding-bottom: 15px;position: relative;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="width: 6px;
    height: 6px;
    background: #000;
    border-radius: 3px;
    display: inline-block;
    margin-right: 5px;"></span>Valid National Identity Card
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>


                                      

                                        <tr>
                                            <td height="20" align="center" valign="top" style="font-size:20px;line-height:20px;">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#F14E4E;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;font-style: italic;">
                                                All photo ID documents must be valid and clearly show your full name, date of birth and issue / expiry date. Student ID cards are not accepted.
                                            </td>
                                        </tr>

                                        <tr>
                                    <td class="heroSubTitle" align="left" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:16px;line-height:20px;font-weight:600;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                                        Proof of Residence, <br>
                                        <table align="left">
                                            <tbody>
                                                <tr>
                                                    <td class="heroSubTitle" align="left" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0; text-align: left;padding-top: 15px;position: relative;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="width: 5px;height: 5px;background: #000;border-radius: 50%;position: absolute;top: 66%;left: 8%;"></span> &nbsp;  Utility Bill, Phone Bill, Bank Statement, Internet Bill, Birth Certificate etc. 
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#F14E4E;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;font-style: italic;">
                                       All proof of residence documents must clearly state your name, current residential address and issue date. Documents must not be older than 3 months.
                                    </td>
                                </tr>

                                <tr>
                                    <td class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                                       If you are unable to provide a Secondary ID document that verifies your Proof of Residence you can provide an additiona Photo ID from the list above.
                                    </td>
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
                                            <td mc:hideable="" mc:edit="" class="heroSubTitle" align="center" valign="middle" style="font-family:'Lato', sans-serif;color:#37393d;font-size:12px;line-height:20px;font-weight:400;letter-spacing:0px;padding:0;padding-bottom:15px; text-align: left;">
                                                {{$mail_data['company_name']}} has a dedicated support department operating 24 hours a day 5 days a week. Please do not hesitate to contact us using live chat or contact us form.<br>
                                                
                                                
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