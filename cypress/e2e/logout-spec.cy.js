describe('Cek Fungsi Logout', () => {
  it('Cek perilaku sistem jika pengguna melakukan logout', () => {
    cy.signIn('farhan12', 'userpass')

    cy.get('[data-cy="btn-dropdown-account"]').click();
    cy.get('[data-cy="btn-logout"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/signIn')
    })

    cy.contains('Log out sukses')
  })
})