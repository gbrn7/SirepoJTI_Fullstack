// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
Cypress.Commands.add('logInStudent', (username, password) => {
  cy.visit('/logIn')

  cy.get('input[name=username]').type(username)

  // {enter} causes the form to submit
  cy.get('input[name=password]').type(`${password}{enter}`, { log: false })

  // we should be redirected to /dashboard
  cy.url().should('include', '/')
})

Cypress.Commands.add('logInAdmin', (username, password) => {
  cy.visit('/logIn/admin')

  cy.get('input[name=username]').type(username)

  // {enter} causes the form to submit
  cy.get('input[name=password]').type(`${password}{enter}`, { log: false })

  // we should be redirected to /dashboard
  cy.url().should('include', '/')
})

Cypress.Commands.add('logInLecturer', (username, password) => {
  cy.visit('/logIn/lecturer')

  cy.get('input[name=username]').type(username)

  // {enter} causes the form to submit
  cy.get('input[name=password]').type(`${password}{enter}`, { log: false })

  // we should be redirected to /dashboard
  cy.url().should('include', '/')
})

//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })