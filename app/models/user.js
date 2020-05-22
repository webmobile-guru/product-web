const mongoose = require('mongoose');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const randtoken = require('rand-token');
const autopopulate = require('mongoose-autopopulate');
const crypto = require('crypto');


const UserSchema = mongoose.Schema({
    firstname: String,
    lastname: String,
    password: {
        type: String,
        required: true,
        validate: {
            validator: function(v) {
                return v.length > 5;
            },
            message: props => 'Password must be at least 6 characters long'
        },
    },
    email: {
        type: String,
        lowercase: true,
        required: [true, "This field can't be blank"],
        match: [/\S+@\S+\.\S+/, 'is invalid'],
        unique: true
    },
    verificationCode: String,
    isVerified: {
        type: Boolean,
        default: false
    },
    refreshToken: {
        token: {
            type: String,
        },
        created: {
            type: Date,
            default: Date.now,
        }
    },
    role: String,
    companyName: String,
    company: {
        type: mongoose.Schema.Types.ObjectId,
        refPath: 'Company',
        autopopulate: { maxDepth: 2 }
    },

}, {
    timestamps: true
});

UserSchema.pre('save', async function (next) {

    if (this.isModified('password') || this.isNew) {

        let err, salt, hash;
        [err, salt] = await to(bcrypt.genSalt(12));
        if (err) TE(err.message, true);

        [err, hash] = await to(bcrypt.hash(this.password, salt));
        if (err) TE(err.message, true);

        this.password = hash;

        // create and save refresh token for user
        const refreshToken = randtoken.uid(256);
        refTok = {
            token: refreshToken,
            created: Date.now()
        }
        this.refreshToken = refTok;

    } else {
        return next();
    }
})

UserSchema.pre('findOneAndUpdate', function(next) {
    this.options.runValidators = true;
    next();
});

UserSchema.methods.comparePassword = async function (pw) {
    let err, pass;
    if (!this.password) TE('password not set');

    [err, pass] = await to(bcrypt.compare(pw, this.password));
    if (err) TE(err);

    if (!pass) TE('invalid password');

    return this;
}

UserSchema.methods.getJWT = function () {
    return "Bearer " + jwt.sign({
        user_id: this._id
    }, CONFIG.jwt_encryption, {});
};

UserSchema.methods.toWeb = function () {
    let json = this.toJSON();
    json.id = this._id;
    json.password = null;
    json.refreshToken = null;
    return json;
};

UserSchema.plugin(autopopulate);

const User = mongoose.model('User', UserSchema);

// create the model for users and expose it to our app
module.exports = User; 