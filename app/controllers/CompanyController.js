const companyService = require('../services/CompanyService');
const userService = require('../services/UserService');

exports.create = async function(req, res) {
    if (!checkProps(req.body, "companyName|emailDomain")) return ReE(res, 'Missing properties for endpoint', 400);
    const {companyName, emailDomain} = req.body;

    let companyJson = {companyName, emailDomain};
    let err, newCompany;

    [err, newCompany] = await to(companyService.create(companyJson));
    if (err) return ReE(res, 'Err creating company: ' + err.message , 500);

    return ReS(res, {
        companyJson
    }, 201);
}

exports.update = async function (req, res) {
    if (!checkProps(req.body, "update")) return ReE(res, 'Missing properties for endpoint', 400);
    const user = req.user;
    const company = user.company;
    const { update } = req.body;
    let err, updatedCompany;

    [err, updatedCompany] = await to(companyService.updateCompany({_id: company._id}, update));
    if (err) return ReE(res, err, 500);

    // UPDATE USER OBJECT TO CHANGE COMPANY NAME
    if(update.companyName) {
        let updatedUser;
        [err, updatedUser] = await to(userService.updateUser({_id: user.id}, update));
        if (err) return ReE(res, err, 500);
    }

    return ReS(res, {
        updatedCompany,
    }, 200); 
}



exports.delete = async function (req, res) {
    const user = req.user;
    const company = user.company;

    let err, _;
    [err, _] = await to(companyService.deleteCompany(company._id));
    if (err) return ReE(res, err);
    return ReS(res, {
        message: 'Company successfully deleted',
    }, 200);
}
