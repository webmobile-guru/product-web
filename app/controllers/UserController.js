const authService = require('../services/AuthService');
const userService = require('../services/UserService');
const emailService = require('../services/EmailService');
const axios = require('axios');

exports.create = async function (req, res) {
    res.setHeader('Content-Type', 'application/json');

    req.sanitize('email').normalizeEmail({
        gmail_remove_dots: false
    });

    req.checkBody('email', 'Enter a valid email address').isEmail();
    const errors = req.validationErrors();
    if (errors) {
        return ReE(res, 'Please enter a valid email to register.', 422);
    }
    const body = req.body;
    if (!body.email) {
        return ReE(res, 'Please enter an email to register.', 422);
    } else if (!body.password) {
        return ReE(res, 'Please enter a password to register.', 422);
    } else if (!body.role) {
        return ReE(res, 'Please enter your role to register.', 422);
    } else if (!body.companyName) {
        return ReE(res, 'Please enter your company to register.', 422);
    } else if (!body.firstname) {
        return ReE(res, 'Please enter your first name to register.', 422);
    } else if (!body.lastname) {
        return ReE(res, 'Please enter your last name to register.', 422);
    } else {
        let err, user, _;
        [err, user] = await to(authService.createUser(body));
        if (err) {
            return ReE(res, err, 422);
        }

        const userJson = user.toWeb();
        return ReS(res, {
            userJson,
            refreshToken: user.refreshToken.token,
            token: user.getJWT(),
        }, 201);
    }
}

exports.update = async function (req, res) {
    if (!checkProps(req.body, "update")) return ReE(res, 'Missing properties for endpoint', 400);
    const user = req.user;
    const { update } = req.body;
    let err, updatedUser;

    [err, updatedUser] = await to(userService.updateUser({_id: user.id}, update));
    if (err) return ReE(res, err, 500);

    return ReS(res, {
        userJson: updatedUser.toWeb(),
    }, 200); 
}

exports.delete = async function (req, res) {
    const user = req.user;
    let err, _;
    [err, _] = await to(userService.deleteUser(user.id));
    if (err) return ReE(res, err)
    return ReS(res, {
        message: 'User successfully deleted',
    }, 200);
}

exports.resendVerificationEmail = async function (req, res) {
    res.setHeader('Content-Type', 'application/json');
    let user = req.user;
    const body = req.body;
    
    //verify user email flow 
    const toInformation = {
        email: user.email
    };
    const args = { code: user.code };
    const subject = 'Verification Code: ' + user.code;
    const template = '/emailVerification.html';
    
    [err, _] = await to(emailService.sendEmail(template, args, toInformation, subject));
    if (err) return TE(err.message, true);

    return ReS(res, {
        //userJson
    });
}

exports.confirmUser = async function(req, res, next) {
    const user = req.user;
    const { code } = req.body

    if(user.code == code) {
        user.isVerified = true

        user.save(function(err) {
            if(err) return ReE(res, err, 422);

            return ReS(res, {
                message: 'Successfully verified user.'
            }, 201);
        })
    } else {
        return ReE(res, 'The confirmation code does not match', 400)
    }
}

exports.get = async function (req, res) {
    res.setHeader('Content-Type', 'application/json');
    let user = req.user;
    const userJson = user.toWeb();

    return ReS(res, {
        userJson
    });
}

exports.login = async function (req, res) {
    if (!checkProps(req.body, "email|password")) return ReE(res, 'Missing properties for endpoint', 400);
    res.setHeader('Content-Type', 'application/json');
    let err, user;
    [err, user] = await to(authService.authUser(req.body));
    if (err) return ReE(res, err, 422);
    
    const userJson = user.toWeb();

    return ReS(res, {
        token: user.getJWT(),
        refreshToken: user.refreshToken.token,
        userJson
    });
}

/**
 * Refresh token for user
 */
exports.refreshUserToken = async function (req, res) {
    let user, refreshToken;
    user = req.user;
    refreshToken = req.body.refreshToken;

    if (user.refreshToken.token === refreshToken) {
        return ReS(res, {
            token: user.getJWT(),
        });
    } else {
        return ReE(res, 'Invalid refresh token');
    }
}

// POST that needs to include token and new password
// Resets forgotten password; different from changing a password
exports.resetPassword = async function (req, res) {
    let err, user;
    [err, user] = await to(authService.resetPassword(req.body));

    if (err) {
        return ReE (res, err, 401);
    }

    return ReS(res, {
        message: 'Successfully updated password!',
    }, 201);
}

exports.unsubscribeEmails = async function (req, res) {
    if (!checkProps(req.body, "email")) return ReE(res, 'Missing properties for endpoint', 400);
    const { email } = req.body;
    let err, user;
    [err, user] = await to(userService.unsubscribeUserFromEmails(email));
    if (err) return ReE(res, err)
    return ReS(res, {
        message: 'User successfully unsubscribed from emails',
    }, 201);
};


exports.queryUsers = async function (req, res) {
    if (!checkProps(req.body, "query")) return ReE(res, 'Missing properties for endpoint', 400);
    const { query } = req.body;

    let err, users;
    [err, users] = await to(userService.queryUsers(query, {}, {new:true}));
    if (err) return ReE(res, err, 500);

    return ReS(res, {
        users
    }, 200);
}
