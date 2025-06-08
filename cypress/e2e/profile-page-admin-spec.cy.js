describe('Cek Fungsi Halaman Profil', () => {
  it('Cek perilaku sistem jika mengupload gambar profil', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-dropdown-account"]').click();
    cy.get('[data-cy="btn-edit-account"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/user')
    })

    cy.get('[data-cy="input-profile-picture"]').selectFile("Cypress/images/github.png");

    cy.get('[data-cy="btn-edit-profile-submit"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home')
    })

    cy.contains('Profil Diperbarui');
  })

  it('Cek perilaku sistem jika mengganti password dengan data yang benar', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-dropdown-account"]').click();
    cy.get('[data-cy="btn-edit-account"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/user')
    })

    cy.get('[data-cy="input-old-password"]').type('adminpass')
    cy.get('[data-cy="input-new-password"]').type('adminpass1')
    cy.get('[data-cy="input-confirm-new-password"]').type('adminpass1')

    cy.get('[data-cy="btn-edit-profile-submit"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home')
    })

    cy.contains('Profil Diperbarui');

    cy.get('.swal2-close').click();

    cy.get('[data-cy="btn-dropdown-account"]').click();
    cy.get('[data-cy="btn-logout"]').click();

    cy.logInAdmin('adminsirepojti', 'adminpass1')

    cy.get('[data-cy="btn-dropdown-account"]').click();
    cy.get('[data-cy="btn-edit-account"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/user')
    })

    cy.get('[data-cy="input-old-password"]').type('adminpass1')
    cy.get('[data-cy="input-new-password"]').type('adminpass')
    cy.get('[data-cy="input-confirm-new-password"]').type('adminpass')

    cy.get('[data-cy="btn-edit-profile-submit"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home')
    })

    cy.contains('Profil Diperbarui');
  })

  it('Cek perilaku sistem jika pengulangan password tidak sama dengan data yang valid', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-dropdown-account"]').click();
    cy.get('[data-cy="btn-edit-account"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/user')
    })

    cy.get('[data-cy="input-old-password"]').type('adminpass')
    cy.get('[data-cy="input-new-password"]').type('adminpass1')
    cy.get('[data-cy="input-confirm-new-password"]').type('adminpass2')

    cy.get('[data-cy="btn-edit-profile-submit"]').click();

    cy.contains('Pengulangan Password Tidak Sama');
  })
})