const express = require("express");
const router = express.Router();
const passport = require("passport");

const UserController = require("./../controllers/UserController");
const TagController = require("./../controllers/TagController");
const CompanyController = require("./../controllers/CompanyController");
const CardController = require("../controllers/CardController");
const SlackController = require("./../controllers/SlackController");

require("./../middleware/passport")(passport);

/* GET home page. */
router.get("/", function(req, res, next) {
  res.json({
    status: "success",
    message: "Parcel Pending API",
    data: { version_number: "v1.0.0" }
  });
});

/**
 * User Endpoints
 */
router.post('/users', UserController.create);
router.get('/users', passport.authenticate('jwt', {session:false}), UserController.get);
router.put('/users', passport.authenticate('jwt', {session:false}), UserController.update);
router.delete('/users', passport.authenticate('jwt', {session:false}), UserController.delete);

router.post('/users/verifyCheck', passport.authenticate('jwt', {session:false}), UserController.confirmUser);
router.post('/users/resendVerification', passport.authenticate('jwt', {session:false}), UserController.resendVerificationEmail);
router.post('/users/login', UserController.login);
router.post('/users/refreshToken', passport.authenticate('jwt', {session:false}), UserController.refreshUserToken);
router.post('/users/resetPassword', UserController.resetPassword);
router.post('/users/unsubscribe', UserController.unsubscribeEmails);
router.post('/users/query', passport.authenticate('jwt', {session:false}), UserController.queryUsers);


/*
 * Company endpoints
 */
router.post("/companies", CompanyController.create);
router.put('/companies', passport.authenticate('jwt', {session:false}), CompanyController.update);
router.delete('/companies', passport.authenticate('jwt', {session:false}), CompanyController.delete);


/*
 * Tag endpoints
 */
router.post("/tags", passport.authenticate('jwt', {session:false}), TagController.create);
router.delete("/tags", passport.authenticate('jwt', {session:false}), TagController.delete);


/*
 * card endpoints
 */

router.put("/index", CardController.createIndex);
router.delete("/index", CardController.createIndex);
router.post("/cards", CardController.createCard);
router.put("/cards", CardController.updateCard);
router.delete("/cards", CardController.deleteCard);
router.post("/cards/searchquery", CardController.search);

/*
SLACK methods
*/
router.get("/auth/slack", passport.authenticate("slack"));
router.get("/auth/slack/callback", passport.authenticate("slack"), UserController.getAuthToken);
router.post("/slack/sendMessage", SlackController.postMessage);
module.exports = router;

/*
Example User Update Request
{
  "update": 
    {
      "firstname": "Akshay",
      "role": "admin"
    }
}

Example User Query Request
{
  "query":{
      "companyName": "Omni Knowledge" 
    
   }
}
*/
