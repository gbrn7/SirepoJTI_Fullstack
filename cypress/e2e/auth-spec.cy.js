describe('Authentication', () => {
  it('Cek perilaku sistem jika Memasukkan username dan password dengan benar ', () => {
    cy.visit('/signIn')

    cy.get('[data-cy="title"]').should('have.text', "Log In Mahasiswa");
    cy.get('[data-cy="input-username"]').type("farhan12");
    cy.get('[data-cy="input-password"]').type("userpass");
    cy.get('[data-cy="btn-login"]').click();

    cy.url().should('eq', Cypress.config().baseUrl + '/')
  })

  it('Cek perilaku sistem jika Memasukkan username dan password dengan data yang salah ', () => {
    cy.visit('/signIn')

    cy.get('[data-cy="title"]').should('have.text', "Log In Mahasiswa");
    cy.get('[data-cy="input-username"]').type("username");
    cy.get('[data-cy="input-password"]').type("password");
    cy.get('[data-cy="btn-login"]').click();

    cy.contains('Username or password invalid!')

    cy.url().should('eq', Cypress.config().baseUrl + '/signIn')
  })

  it('Cek perilaku sistem jika Menekan tombol untuk beralih ke halaman login jenis pengguna Dosen', () => {
    cy.visit('/signIn')

    cy.get('[data-cy="title"]').should('have.text', "Log In Mahasiswa");
    cy.get('.link-text').contains('Dosen').click();
    cy.get('[data-cy="title"]').should('have.text', "Log In Dosen");

    cy.url().should('eq', Cypress.config().baseUrl + '/signIn/lecturer')
  })

  it('Cek perilaku sistem jika Menekan tombol untuk beralih ke halaman login jenis pengguna Admin', () => {
    cy.visit('/signIn')

    cy.get('[data-cy="title"]').should('have.text', "Log In Mahasiswa");
    cy.get('.link-text').contains('Admin').click();
    cy.get('[data-cy="title"]').should('have.text', "Log In Admin");

    cy.url().should('eq', Cypress.config().baseUrl + '/signIn/admin')
  })

  it('Cek perilaku sistem jika Menekan tombol untuk beralih ke halaman login jenis pengguna Mashasiswa', () => {
    cy.visit('/signIn')

    cy.get('[data-cy="title"]').should('have.text', "Log In Mahasiswa");
    cy.get('.link-text').contains('Admin').click();
    cy.get('.link-text').contains('Mahasiswa').click();
    cy.get('[data-cy="title"]').should('have.text', "Log In Mahasiswa");

    cy.url().should('eq', Cypress.config().baseUrl + '/signIn')
  })
})