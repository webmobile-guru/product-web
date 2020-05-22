const nodemailer = require('nodemailer');
const jade = require('jade');

const transporter = nodemailer.createTransport({ service: 'Sendgrid', auth: { user: CONFIG.sendgrid_username, pass: CONFIG.sendgrid_password } });

const templateDir = 'app/templates';
    

/** 
 * template is string that references the html file
 * args is an object that is passed into the jade file
 * to is an object with firstname, lastname, email
 * subject is "header" for email
 * */ 
exports.sendEmail = async function(template, args, toInfo, subject) {
    const emailTemplate = jade.renderFile(templateDir + template, args);
    const { email } = toInfo;

    const mailOptions = {
            from: 'Omni <team@addomni.com>',
            to: '<' + email + '>',
            subject,
            html: emailTemplate,
            text:'text'
    };

    transporter.sendMail(mailOptions, function (err) {
        if (err) TE(err.message);
    });
}