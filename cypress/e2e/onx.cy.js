const faker = require('faker')
 
const DOMAIN = 'https://onx-it.letscode.it'
 
 
describe('Full test', () => {
 
  const firstname = faker.name.firstName()
  const lastname = faker.name.lastName()
 
  const email = faker.internet.email()
 
  const password = faker.internet.password();
 
  it('Register new account', () => {
    cy.visit(DOMAIN + '/signup')
 
    cy.get('#firstname').type(firstname)
    cy.get('#lastname').type(lastname)
 
    cy.get('button[aria-label="Next"]').click()
 
 
 
 
    cy.get('#email').type(email)
 
    cy.get('button[aria-label="Next"]').click()
 
 
 
 
    cy.get('input[type=password]').eq(1).type(password)
    cy.get('input[type=password]').eq(0).type(password)
 
    cy.get('button[aria-label="Next"]').click()
 
 
    cy.get('button[aria-label="Create Account!"]').click()
 
    cy.contains(firstname + ' ' + lastname).click()
 
    cy.contains("Logout").click()
 
  })
 
 
  it('Add multiple addresses', () => {
 
    cy.visit(DOMAIN)
    cy.get('#email').type(email)
    cy.get('input[type=password]').type(password)
    cy.get('button[aria-label="Login"]').click()
 
    const addresses = ['warszawa', 'wyszków', 'długosiodło', '07-210', /* '07-200', 'poznań', 'wrocław', 'królowej jadwigi', 'gdańsk', 'gdynia', 'limanowa', 'rzeszów', 'świętojańska', 'prosta' */]
 
    addresses.forEach((d) => {
      cy.get('[aria-label="New address"]').click()
 
      cy.get('[role="dialog"] input').type(d)
 
      cy.get('[role=listbox] li').eq(0).click()
 
      cy.contains("Submit").click()
    })
 
  })
 
 
  it('Edit friendly name on first address', () => {
 
    cy.visit(DOMAIN)
    cy.get('#email').type(email)
    cy.get('input[type=password]').type(password)
    cy.get('button[aria-label="Login"]').click()
 
    cy.get('[aria-label="Details"]').eq(0).click()
 
    cy.get('input[placeholder="Friendly name"]').type(faker.random.words(4))
 
    cy.get('button.p-button-success').click()
 
    cy.get('.p-dialog-header-close-icon').click()
  })
 
 
  it('Delete all addresses ', () => {
 
    cy.visit(DOMAIN)
    cy.get('#email').type(email)
    cy.get('input[type=password]').type(password)
    cy.get('button[aria-label="Login"]').click()
 
    cy.get('.p-checkbox.p-component').eq(1).click()
    cy.get('.p-checkbox.p-component').eq(2).click()
    cy.get('.p-checkbox.p-component').eq(3).click()
 
    cy.contains('immediately').click()
  })
 
 
 
})