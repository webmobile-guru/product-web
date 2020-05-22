const User = require('../models').User;


exports.getUserById = async function (Id) {
    let err, user;
    [err, user] = await to(User.findOne({"_id":Id}));
    if (err) TE("Unable to find user: " + err.message);

    return user;
}

exports.getUserByToken = async function (token) {
    let err, user;
    [err, user] = await to(User.findOne({"token": token}));
    if (err) TE("Unable to find user: " + err.message);

    return user;
}

getUserByEmail = async function (email) {
    let err, user;
    [err, user] = await to(User.findOne({email}));
    if (err) TE("Unable to find user: " + err.message);

    return user;
}

exports.updateUser = async function (filter, update) {
    let err, user;

    [err, user] = await to(User.findOneAndUpdate(filter, update, {new: true}));
    if (err) TE("Unable to update user: " + err.message);

    return user;
}

exports.deleteUser = async function(userId) {
    let err, _;
    [err, _] = await to(User.findByIdAndDelete(userId));
    if (err) TE("Unable to delete user: " + err.message);
}

exports.unsubscribeUserFromEmails = async function (email) {
    let err, user; 
    [err, user] = await to(User.findOne({email}));
    if (err) TE("Unable to find user: " + err.message);

    user.unsubscribed = true;
    [err, user] = await to(user.save());
    if (err) TE("Unable to unsubscribe user from emails: " + err.message);
    
    return user;
}


exports.queryUsers = async function (filter, projection = {}, options = {}) {
    let err, users;
    [err, users] = await to(User.find(filter, projection, options));
    if (err) TE("Error fetching users: " + err.message);

    return users;
}
