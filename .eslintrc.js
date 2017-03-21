module.exports = {
    "env": {
        "browser": true,
        "commonjs": true,
        "es6": true,
        "jquery": true,
    },
    "extends": ["vue", "eslint:recommended"],
    "plugins": ["vue"],
    "parserOptions": {
        "sourceType": "module"
    },
    "rules": {
        "linebreak-style": [
            "error",
            "unix"
        ],
		"no-console": "off",
    }
};
